<?php

namespace App\Warehouse;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\Models\MaterialSummary;
use App\Models\ProjectMaterial;
use App\Models\Workflow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Registra un movimiento de almacen (cabecera en mat_materials_summary + lineas en mat_projects_materials),
 * escribiendo exactamente lo mismo que Serebo (Warehouse::_index + Model_material_summary::saveMaterials),
 * porque ambos sistemas comparten las tablas durante la transicion.
 *
 * Diferencias deliberadas con Serebo:
 *  - Valida en servidor (MovementValidator) con el stock leido dentro de la transaccion.
 *  - fiscal_responsible solo se guarda en los tipos que lo piden (Serebo lo guardaba siempre).
 *  - El numero de reserva solo se guarda en los tipos que lo piden (3 y 8 en esta etapa).
 */
final class RegisterWarehouseMovement
{
	public function __construct(private MovementValidator $validator = new MovementValidator())
	{
	}

	/**
	 * @param array{type_id:int,project_id:int,builder_id?:?int,fiscal_id?:?int,reservation_number?:?string,entry_date:string,allow_empty?:bool} $header
	 *        entry_date en formato Y-m-d (la hora se toma del momento de guardar, como en Serebo).
	 * @param array<int,array{material_id:int,tension:int,status:int,quantity:mixed,detail?:?string,material_code?:string}> $lines
	 * @param int|null $requestId solicitud que respalda la entrega (parent_summary_id)
	 *
	 * @throws MovementRejectedException
	 */
	public function execute(array $header, array $lines, ?int $userId, ?int $requestId = null): MaterialSummary
	{
		$summary = DB::transaction(function () use ($header, $lines, $userId, $requestId) {
			$typeId = (int)$header['type_id'];
			$projectId = (int)$header['project_id'];

			// ---------- Validar con datos frescos ----------
			$request = $requestId ? $this->loadRequest($requestId) : null;
			if ($requestId && $request === null)
				throw new MovementRejectedException([['field' => 'request_id', 'message' => 'No se encuentra la solicitud.', 'lines' => []]]);

			$stock = $this->stockSnapshot($projectId, $typeId, $header['reservation_number'] ?? null);
			$errors = $this->validator->validate($header, $lines, $stock, $request);
			if (count($errors) > 0)
				throw new MovementRejectedException($errors);

			// ---------- Cabecera ----------
			$withBuilderAndFiscal = MovementType::requiresBuilderAndFiscal($typeId);
			$correlative = MaterialSummary::where('project_id_msu', $projectId)
				->where('summary_type_id_msu', $typeId)
				->where('deleted_msu', '!=', 1)
				->count() + 1; // igual que Serebo: getSummariesByProjectAndType + 1

			$summary = MaterialSummary::forceCreate([
				'tension_level_msu' => 'TODOS',
				'project_id_msu' => $projectId,
				'applicant_project_id_msu' => $projectId,
				'graph_number_msu' => '',
				'destiny_msu' => '',
				'entry_date_msu' => $header['entry_date'] . ' ' . date('H:i:s'),
				'detail_msu' => '',
				'builder_responsible_msu' => $withBuilderAndFiscal ? $header['builder_id'] : null,
				'summary_type_id_msu' => $typeId,
				'reservation_number_msu' => MovementType::requiresReservation($typeId) ? $header['reservation_number'] : null,
				'parent_summary_id_msu' => $requestId,
				'is_loan_msu' => 0,
				'correlative_counter_msu' => $correlative,
				'fiscal_responsible_msu' => $withBuilderAndFiscal ? $header['fiscal_id'] : null,
				'createdby_msu' => $userId,
			]);

			// ---------- Lineas (las lineas en cero no se guardan, como en Serebo) ----------
			foreach ($lines as $line)
			{
				$cents = Quantity::parse($line['quantity'] ?? 0);
				if (!$cents)
					continue;

				ProjectMaterial::forceCreate([
					'materials_summary_id_prm' => $summary->getKey(),
					'material_id_prm' => (int)$line['material_id'],
					'quantity_prm' => Quantity::format($cents),
					'status_id_prm' => (int)$line['status'],
					'tension_id_prm' => (int)$line['tension'],
					'delivered_to_builder_detail_prm' => $typeId === MovementType::DELIVERED_TO_BUILDER ? ($line['detail'] ?? null) : null,
					'createdby_prm' => $userId,
				]);
			}

			return $summary;
		});

		// Despues del commit, igual que WorkflowSyncNotifier en Serebo: un fallo se registra pero no revierte el movimiento.
		try
		{
			Workflow::refreshProject((int)$header['project_id']);
		}
		catch (\Throwable $e)
		{
			Log::error('[RegisterWarehouseMovement] No se pudo refrescar workflows del proyecto ' . $header['project_id'] . ': ' . $e->getMessage());
		}

		return $summary;
	}

	/**
	 * Solicitud (tipo 14/15) con sus lineas, en la forma que espera MovementValidator.
	 *
	 * @return array{id:int,project_id:int,type_id:int,lines:array}|null
	 */
	public function loadRequest(int $requestId): ?array
	{
		$request = MaterialSummary::where('deleted_msu', '!=', 1)->whereKey($requestId)->first();
		if (!$request)
			return null;

		$lines = ProjectMaterial::where('materials_summary_id_prm', $request->getKey())
			->where('deleted_prm', '!=', 1)
			->get();

		return [
			'id' => (int)$request->getKey(),
			'project_id' => (int)$request->project_id_msu,
			'type_id' => (int)$request->summary_type_id_msu,
			'lines' => $lines->map(fn ($l) => [
				'material_id' => (int)$l->material_id_prm,
				'tension' => (int)($l->tension_id_prm ?? MaterialSummaryPaginationHandler::UNDEFINED_ID),
				'status' => (int)($l->status_id_prm ?? MaterialSummaryPaginationHandler::UNDEFINED_ID),
				'quantity' => $l->quantity_prm,
				'detail' => $l->request_cre_detail_prm,
			])->all(),
		];
	}

	/**
	 * Stock del proyecto (una fila por material + tension + estado). Para los tipos que piden reserva,
	 * el pendiente se calcula solo con esa reserva, igual que la pantalla de Serebo.
	 */
	public function stockSnapshot(int $projectId, int $typeId, ?string $reservationNumber = null): StockSnapshot
	{
		return StockSnapshot::fromRows(self::stockRows($projectId, $typeId, $reservationNumber));
	}

	/**
	 * @return array<int,array>
	 */
	public static function stockRows(int $projectId, int $typeId, ?string $reservationNumber = null): array
	{
		$handler = new MaterialSummaryPaginationHandler(100000, 0, 'project_material');
		$parameters = ['project-id' => $projectId];
		if (MovementType::requiresReservation($typeId) && trim((string)$reservationNumber) !== '')
			$parameters['reservation-number'] = $reservationNumber;
		$handler->setAdditionalParameters($parameters);
		$handler->setReturnAsObjectCollection(false);
		return $handler->getAll();
	}
}