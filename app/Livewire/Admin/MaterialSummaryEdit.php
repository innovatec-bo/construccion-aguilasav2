<?php

namespace App\Livewire\Admin;

use App\Models\Material;
use App\Models\ProjectMaterial;
use App\Models\SummaryType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class MaterialSummaryEdit extends Component
{
    use WithPagination;

    public $search;
    public $sort = 'description_mat';
    public $direction = 'asc';
    public $manualEntryDate;
    public $materialsSummary;
    public $materialsSummaryTypeId;
    public $materialSummaryTypes;
    public $fiscalId;
    public $fiscals;
    public $builderId;
    public $builders;
    public $laborDetailSummary;
    public $hideResponsibles;
    public $reservationNumber;
    public $reservationNumberList;
    public $materialsToMove;
    
    protected $messages = [
        'manualEntryDate.date_format' => 'El formato de :attribute debe ser dd-mm-yyyy HH:mm:ss',
    ];

    protected $validationAttributes = [
        'manualEntryDate' => 'fecha'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->fiscalId = $this->materialsSummary->fiscal_responsible_msu;
        $this->builderId = $this->materialsSummary->builder_responsible_msu;
        $this->materialsSummaryTypeId = $this->materialsSummary->summary_type_id_msu;
        $this->fiscals = User::role('fiscal')->get();
        $this->builders = User::role('builder')->get();
        $this->manualEntryDate = $this->materialsSummary->entry_date_msu->format('d-m-Y H:i:s');
        $this->materialSummaryTypes = SummaryType::whereIn('keyword_mqt', ['materials_additional_list','materials_picked_up_from_cre','materials_delivered_to_builder','materials_delivered_to_builder_loan','builder_returns_materials'])->get();
        $this->laborDetailSummary = $this->materialsSummary->project->laborDetailDesign?$this->materialsSummary->project->laborDetailDesign->summary($this->materialsSummary):[];
        $this->reservationNumberList = $this->materialsSummary->project->materialSummaries()->whereNotNull('reservation_number_msu')->groupBy('reservation_number_msu')->get()->pluck('reservation_number_msu');
        $this->materialsToMove = collect($this->materialsSummary->projectMaterials()->with('material')->get()->toArray())->sortBy('material_id_prm');
        $this->responsiblesVisibility();
    }

    public function rules()
    {
        return [
            'manualEntryDate' => 'date_format:d-m-Y H:i:s',
            'materialsToMove.*.quantity_prm' => 'numeric'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $materials = Material::Where(function($query){
            $query->where('code_mat','like','%'.$this->search.'%')
            ->orWhere('name_mat','like','%'.$this->search.'%')
            ->orWhere('description_mat','like','%'.$this->search.'%');
        })
        // ->whereNotIn('id_mat', array_keys($this->currentList))
        ->orderBy($this->sort, $this->direction)
        ->paginate(4);

        return view('livewire.material-summary-edit', compact('materials'));
    }

    public function save()
    {
        $this->validate();
        $this->materialsSummary->entry_date_msu = Carbon::createFromFormat('d-m-Y H:i:s', $this->manualEntryDate)->format('Y-m-d H:i:s');
        $this->materialsSummary->save();
        //Deleting current data
        $idsToDelete = [];
        foreach ($this->materialsSummary->projectMaterials as $row) 
        {
            $idsToDelete[] = $row->id_prm;
        }
        if(count($idsToDelete) > 0)
        {
            ProjectMaterial::destroy($idsToDelete);
        }
        //Preparing new data
        $toSave = [];
        foreach ($this->materialsToMove as $row) 
        {
            $toSave[] = [
                'materials_summary_id_prm' => $row['materials_summary_id_prm'],
                'material_id_prm' => $row['material_id_prm'],
                'quantity_prm' => $row['quantity_prm'],
                'status_id_prm' => $row['status_id_prm'],
                'tension_id_prm' => $row['tension_id_prm']
            ];
        }
        $object = new ProjectMaterial();
            $toSave = array_map(function ($data) use ($object) {
                $timestamp = $object->freshTimestampString();
                $data['created_at'] = $timestamp;
                $data['created_by'] = Auth::user()->id_usr;
                return $data;
            }, $toSave);
        ProjectMaterial::insert($toSave);
        Session::flash('successMessage', 'Movimiento actualizado exitosamente.');
        return redirect()->route('admin.materials-summary.show', $this->materialsSummary->id_msu);
    }

    public function responsiblesVisibility()
    {
        switch($this->materialsSummaryTypeId)
		{
			case 4:
			case 10:
			case 11:
			case 14:
			case 15:
            case 17:
			case 18:
				$this->hideResponsibles = '';
				break;
			default:
                $this->hideResponsibles = 'd-none';
		}
    }

    public function addToCurrentList(Material $material)
    {
        // dd($this->laborDetailSummary[$material->code_mat]);
        $data = [
            'material_id_prm' => $material->id_mat,
            'materials_summary_id_prm' => $this->materialsSummary->id_msu,
            'tension_id_prm' => 4,
            'material' => $material->toArray()
        ];
        $this->materialsToMove->push($data);
        $this->materialsToMove = $this->materialsToMove->sortBy('material_id_prm')->values();
    }

    public function reservationNumberVisibility()
    {
        switch($this->reservationNumber)
		{
			case 8:
			case 3:
				$this->hideReservationNumber = '';
				break;
			default:
            $this->hideReservationNumber = 'd-none';
		}
    }

    public function removeFromMaterialsToMove($index)
    {
        unset($this->materialsToMove[$index]);
    }
}