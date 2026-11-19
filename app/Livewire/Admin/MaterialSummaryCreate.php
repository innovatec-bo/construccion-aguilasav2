<?php

namespace App\Livewire\Admin;

use App\Models\Material;
use App\Models\MaterialSummary;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\SummaryType;
use App\Warehouse\MovementRejectedException;
use App\Warehouse\MovementType;
use App\Warehouse\Quantity;
use App\Warehouse\RegisterWarehouseMovement;
use App\Warehouse\StockSnapshot;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * Formulario de movimientos de almacen y solicitudes (reemplaza Warehouse::registerMovement /
 * requestMaterials de Serebo). Las reglas viven en App\Warehouse (MovementValidator) y el guardado en
 * RegisterWarehouseMovement; este componente solo arma el formulario y muestra los errores.
 */
class MaterialSummaryCreate extends Component
{
    public array $movementTypes = [];     // id => nombre
    public $movementTypeSelected;
    public string $requestId = '';
    public string $entryDate = '';        // d-m-Y (flatpickr)
    public string $projectCode = '';
    public ?int $projectId = null;
    public string $projectLabel = '';
    public string $reservationNumber = '';
    public array $reservationOptions = [];
    public $fiscalId = null;
    public $builderId = null;
    public array $lines = [];
    public string $materialSearch = '';
    public bool $allowEmpty = false;
    public array $stockRows = [];         // solo para mostrar; al guardar se vuelve a leer de la base
    public array $movementErrors = [];    // errores de MovementValidator

    private const SLIM_COLUMNS = [
        'material_id', 'material_code', 'material_description', 'tension_id_prm', 'status_id_prm',
        'quantity_assigned_materials', 'quantity_picked_up_from_cre', 'pending_material_in_cre',
        'quantity_materials_delivered_to_builder', 'quantity_in_warehouse',
    ];

    public function mount()
    {
        $this->movementTypes = SummaryType::whereIn('id_mqt', MovementType::ENABLED)
            ->where('deleted_mqt', '!=', 1)
            ->orderBy('id_mqt')
            ->pluck('name_mqt', 'id_mqt')
            ->all();
        $this->movementTypeSelected = MovementType::PICKED_UP_FROM_CRE;
        $this->entryDate = date('d-m-Y');
    }

    public function render()
    {
        return view('livewire.admin.material-summary-create');
    }

    // ------------------------------------------------------------------ catalogos

    #[Computed]
    public function fiscals()
    {
        return $this->usersWithRole(8);
    }

    #[Computed]
    public function builders()
    {
        return $this->usersWithRole(9);
    }

    private function usersWithRole(int $roleId)
    {
        return DB::table('sec_users as u')
            ->join('sec_userroles as r', 'r.userid_uro', '=', 'u.id_usr')
            ->where('r.roleid_uro', $roleId)
            ->where('r.deleted_uro', '!=', 1)
            ->where('u.deleted_usr', '!=', 1)
            ->orderBy('u.firstname_usr')
            ->selectRaw("u.id_usr as id, concat(u.firstname_usr, ' ', u.lastname_usr) as name")
            ->distinct()
            ->get();
    }

    #[Computed]
    public function needsBuilderAndFiscal(): bool
    {
        return MovementType::requiresBuilderAndFiscal((int)$this->movementTypeSelected);
    }

    #[Computed]
    public function needsReservation(): bool
    {
        return MovementType::requiresReservation((int)$this->movementTypeSelected);
    }

    #[Computed]
    public function stock(): StockSnapshot
    {
        return StockSnapshot::fromRows($this->stockRows);
    }

    #[Computed]
    public function materialResults()
    {
        $term = trim($this->materialSearch);
        if (mb_strlen($term) < 2)
            return collect();

        $like = '%' . str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $term) . '%';
        return Material::where('deleted_mat', '!=', 1)
            ->where(function ($q) use ($like) {
                $q->whereRaw("code_mat like ? escape '!'", [$like])
                  ->orWhereRaw("description_mat like ? escape '!'", [$like]);
            })
            ->orderBy('code_mat')
            ->limit(15)
            ->get(['id_mat', 'code_mat', 'description_mat']);
    }

    /**
     * Numeros de una linea tomados del stock del proyecto (solo para mostrar).
     */
    public function lineInfo(array $line): array
    {
        $material = (int)$line['material_id'];
        $tension = (int)$line['tension'];
        $status = (int)$line['status'];

        $row = null;
        foreach ($this->stockRows as $candidate)
        {
            if ((int)$candidate['material_id'] === $material && (int)$candidate['tension_id_prm'] === $tension && (int)$candidate['status_id_prm'] === $status)
            {
                $row = $candidate;
                break;
            }
        }

        return [
            'assigned' => $row['quantity_assigned_materials'] ?? 0,
            'picked' => $row['quantity_picked_up_from_cre'] ?? 0,
            'pending' => Quantity::format($this->stock()->pending($material)),
            'delivered' => $row['quantity_materials_delivered_to_builder'] ?? 0,
            'available' => $row['quantity_in_warehouse'] ?? 0,
        ];
    }

    // ------------------------------------------------------------------ eventos del formulario

    public function updatedMovementTypeSelected()
    {
        $this->resetLinesAndErrors();
        $this->requestId = '';
        if ($this->projectId)
        {
            // el estado permitido del proyecto depende del tipo
            $this->resolveProject();
        }
        $this->reservationNumber = '';
        $this->loadStock();
    }

    public function updatedProjectCode()
    {
        $this->resetLinesAndErrors();
        $this->requestId = '';
        $this->resolveProject();
    }

    public function updatedReservationNumber()
    {
        // el pendiente de los tipos 3 y 8 se calcula con la reserva elegida
        $this->loadStock();
    }

    public function resolveProject()
    {
        $this->resetErrorBag('projectCode');
        $this->projectId = null;
        $this->projectLabel = '';
        $this->reservationOptions = [];
        $this->stockRows = [];

        $code = trim($this->projectCode);
        if ($code === '')
            return;

        $project = Project::where('code_pro', $code)->where('deleted_pro', '!=', 1)->first();
        if (!$project)
        {
            $this->addError('projectCode', 'No se encuentra el proyecto.');
            return;
        }

        $allowedStatusIds = ProjectStatus::whereIn('keyword_pst', MovementType::projectStatusKeywords((int)$this->movementTypeSelected))
            ->pluck('id_pst')
            ->all();
        if (!in_array((int)$project->status_pro, $allowedStatusIds, true))
        {
            $this->addError('projectCode', 'El estado del proyecto no permite este movimiento.');
            return;
        }

        $this->projectId = (int)$project->id_pro;
        $this->projectLabel = $project->code_pro;
        $this->reservationOptions = MaterialSummary::where('project_id_msu', $this->projectId)
            ->whereIn('summary_type_id_msu', [1, 2])
            ->where('deleted_msu', '!=', 1)
            ->whereNotNull('reservation_number_msu')
            ->where('reservation_number_msu', '!=', '')
            ->distinct()
            ->orderBy('reservation_number_msu')
            ->pluck('reservation_number_msu')
            ->all();
        $this->loadStock();
    }

    private function loadStock()
    {
        unset($this->stock);
        $this->stockRows = [];
        if (!$this->projectId)
            return;

        $rows = RegisterWarehouseMovement::stockRows($this->projectId, (int)$this->movementTypeSelected, $this->reservationNumber);
        $this->stockRows = array_map(function ($row) {
            return array_intersect_key((array)$row, array_flip(self::SLIM_COLUMNS));
        }, $rows);
    }

    private function resetLinesAndErrors()
    {
        $this->lines = [];
        $this->movementErrors = [];
        $this->resetErrorBag();
    }

    // ------------------------------------------------------------------ lineas

    public function addMaterial(int $materialId)
    {
        if (!$this->projectId)
        {
            $this->addError('projectCode', 'Debe especificar un proyecto.');
            return;
        }

        $material = Material::where('deleted_mat', '!=', 1)->find($materialId);
        if ($material)
        {
            $this->lines[] = $this->newLine($material->id_mat, $material->code_mat, $material->description_mat, 4, 1);
        }
        $this->materialSearch = '';
    }

    public function removeLine(int $index)
    {
        unset($this->lines[$index]);
        $this->lines = array_values($this->lines);
        $this->movementErrors = [];
    }

    public function clearLines()
    {
        $this->resetLinesAndErrors();
    }

    /**
     * Rellena la tabla con lo que el tipo de movimiento puede mover (sin cantidades).
     */
    public function showAll()
    {
        if (!$this->projectId)
        {
            $this->addError('projectCode', 'Debe especificar un proyecto.');
            return;
        }
        if ($this->needsReservation && $this->reservationNumber === '')
        {
            $this->addError('reservationNumber', 'Seleccione un Nro. de reserva.');
            return;
        }

        $type = (int)$this->movementTypeSelected;
        $lines = [];
        $seenMaterials = [];
        foreach ($this->stockRows as $row)
        {
            $material = (int)$row['material_id'];
            $tension = (int)$row['tension_id_prm'];
            $status = (int)$row['status_id_prm'];

            switch ($type)
            {
                case MovementType::PICKED_UP_FROM_CRE:
                case MovementType::REQUEST_LOAN:
                    // una linea por material con pendiente; se asume Nuevo (el encargado puede cambiarlo)
                    if (Quantity::fromDb($row['pending_material_in_cre']) > 0 && !isset($seenMaterials[$material]))
                    {
                        $seenMaterials[$material] = true;
                        $lines[] = $this->newLine($material, $row['material_code'], $row['material_description'], $tension, 1);
                    }
                    break;

                case MovementType::BUILDER_RETURNS:
                    // lo entregado al constructor; lo retirado de obra se agrega con el buscador
                    if (Quantity::fromDb($row['quantity_materials_delivered_to_builder']) > 0)
                        $lines[] = $this->newLine($material, $row['material_code'], $row['material_description'], $tension, 1);
                    break;

                default:
                    // salidas y solicitudes: una linea por fila con disponible
                    if (Quantity::fromDb($row['quantity_in_warehouse']) > 0)
                        $lines[] = $this->newLine($material, $row['material_code'], $row['material_description'], $tension, $status);
            }
        }
        $this->lines = $lines;
        $this->movementErrors = [];
    }

    /**
     * Coloca en la linea la cantidad maxima permitida por las reglas (no aplica a devoluciones en estado viejo).
     */
    public function useMax(int $index)
    {
        if (!isset($this->lines[$index]))
            return;

        $line = $this->lines[$index];
        $material = (int)$line['material_id'];
        $tension = (int)$line['tension'];
        $status = (int)$line['status'];
        $type = (int)$this->movementTypeSelected;
        $stock = $this->stock();

        $used = 0; // lo que ya piden las otras lineas que comparten el mismo tope
        foreach ($this->lines as $i => $other)
        {
            if ($i === $index)
                continue;
            $sameMaterial = (int)$other['material_id'] === $material;
            $sameRow = $sameMaterial && (int)$other['tension'] === $tension && (int)$other['status'] === $status;
            $cents = Quantity::parse($other['quantity']) ?? 0;

            switch ($type)
            {
                case MovementType::PICKED_UP_FROM_CRE:
                case MovementType::REQUEST_LOAN:
                    if ($sameMaterial) $used += $cents;
                    break;
                case MovementType::BUILDER_RETURNS:
                    if ($sameMaterial && (int)$other['status'] === 1) $used += $cents;
                    break;
                default:
                    if ($sameRow) $used += $cents;
            }
        }

        switch ($type)
        {
            case MovementType::PICKED_UP_FROM_CRE:
            case MovementType::REQUEST_LOAN:
                $max = $stock->pending($material) - $used;
                break;
            case MovementType::BUILDER_RETURNS:
                if ($status !== 1)
                    return; // sin tope
                $max = $stock->deliveredNewNet($material) - $used;
                break;
            default:
                $max = $stock->available($material, $tension, $status) - $used;
        }

        $this->lines[$index]['quantity'] = Quantity::format(max(0, $max));
    }

    private function newLine(int $materialId, string $code, ?string $description, int $tension, int $status, $quantity = ''): array
    {
        return [
            'uid' => uniqid('l', true),
            'material_id' => $materialId,
            'code' => $code,
            'description' => (string)$description,
            'tension' => $tension,
            'status' => $status,
            'quantity' => $quantity,
            'detail' => '',
        ];
    }

    // ------------------------------------------------------------------ solicitud de origen (request-id de Serebo)

    public function loadRequest()
    {
        $this->resetLinesAndErrors();
        $request = app(RegisterWarehouseMovement::class)->loadRequest((int)$this->requestId);
        if (!$request)
        {
            $this->addError('requestId', 'No se encuentra la lista de solicitud.');
            return;
        }

        // la entrega que corresponde a cada solicitud
        $deliveryType = [MovementType::REQUEST_MATERIALS => MovementType::DELIVERED_TO_BUILDER, MovementType::REQUEST_LOAN => MovementType::DELIVERED_TO_BUILDER_LOAN][$request['type_id']] ?? null;
        if ($deliveryType === null)
        {
            $this->addError('requestId', 'Debe ingresar un codigo de una solicitud de materiales o de prestamo.');
            return;
        }

        $summary = MaterialSummary::find($request['id']);
        $project = Project::find($request['project_id']);
        $this->movementTypeSelected = $deliveryType;
        $this->projectCode = (string)($project->code_pro ?? '');
        $this->fiscalId = $summary->fiscal_responsible_msu;
        $this->builderId = $summary->builder_responsible_msu;
        $this->resolveProject();

        $descriptions = Material::whereIn('id_mat', array_column($request['lines'], 'material_id'))->get()->keyBy('id_mat');
        foreach ($request['lines'] as $line)
        {
            $material = $descriptions->get($line['material_id']);
            $this->lines[] = $this->newLine(
                $line['material_id'],
                (string)($material->code_mat ?? $line['material_id']),
                $material->description_mat ?? '',
                $line['tension'],
                $line['status'],
                Quantity::format(Quantity::fromDb($line['quantity']))
            );
        }
    }

    // ------------------------------------------------------------------ guardar

    public function save()
    {
        $this->authorizeMovement();
        $this->movementErrors = [];
        $this->resetErrorBag();

        $header = [
            'type_id' => (int)$this->movementTypeSelected,
            'project_id' => (int)$this->projectId,
            'builder_id' => $this->builderId ? (int)$this->builderId : null,
            'fiscal_id' => $this->fiscalId ? (int)$this->fiscalId : null,
            'reservation_number' => $this->reservationNumber,
            'entry_date' => $this->entryDateForDb(),
            'allow_empty' => $this->allowEmpty,
        ];
        $lines = array_map(fn ($l) => [
            'material_id' => $l['material_id'],
            'material_code' => $l['code'],
            'tension' => $l['tension'],
            'status' => $l['status'],
            'quantity' => $l['quantity'],
            'detail' => $l['detail'] ?? null,
        ], array_values($this->lines));

        try
        {
            $summary = app(RegisterWarehouseMovement::class)->execute(
                $header,
                $lines,
                auth()->id(),
                $this->requestId !== '' ? (int)$this->requestId : null
            );
        }
        catch (MovementRejectedException $e)
        {
            $this->movementErrors = $e->errors();
            foreach ($e->errors() as $error)
            {
                $this->addError(self::fieldToProperty($error['field']), $error['message']);
            }
            return;
        }

        $message = 'El movimiento se registro correctamente. Codigo: ' . $summary->getKey();
        session()->flash('success', $message);
        $this->reset(['requestId', 'lines', 'allowEmpty', 'movementErrors', 'materialSearch']);
        $this->loadStock(); // refresca los numeros mostrados
    }

    /**
     * Gancho para spatie/laravel-permission + policy (pendiente).
     */
    protected function authorizeMovement(): void
    {
        // $this->authorize('create', MaterialSummary::class);
    }

    /** d-m-Y (flatpickr) -> Y-m-d. Vacio si la fecha no existe (por ejemplo 31-02-2026). */
    private function entryDateForDb(): string
    {
        $date = DateTime::createFromFormat('d-m-Y', $this->entryDate);
        if (!$date || $date->format('d-m-Y') !== $this->entryDate)
            return '';
        return $date->format('Y-m-d');
    }

    private static function fieldToProperty(string $field): string
    {
        return [
            'project_id' => 'projectCode',
            'builder_id' => 'builderId',
            'fiscal_id' => 'fiscalId',
            'reservation_number' => 'reservationNumber',
            'entry_date' => 'entryDate',
            'request_id' => 'requestId',
            'type_id' => 'movementTypeSelected',
        ][$field] ?? 'lines';
    }
}