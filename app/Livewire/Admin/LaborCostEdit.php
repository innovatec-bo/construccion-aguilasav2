<?php

namespace App\Livewire\Admin;

use App\Models\CustomStructureMaterial;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class LaborCostEdit extends Component
{
    use WithPagination;

    public $laborCost;
    public $search;
    public $sort = 'description_mat';
    public $direction = 'asc';
    public $currentList = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        foreach ($this->laborCost->customStructureMaterials as $custom) 
        {
            $this->currentList[$custom->material->id_mat] = [
                'id_mat' => $custom->material->id_mat,
                'code_mat' => $custom->material->code_mat,
                'description_mat' => $custom->material->description_mat,
                'quantity_csm' => $custom->quantity_csm,
                'unit_of_measurement_mat' => $custom->material->unit_of_measurement_mat
            ];
        }
    }

    public function render()
    {
        $materials = Material::Where(function($query){
            $query->where('code_mat','like','%'.$this->search.'%')
            ->orWhere('name_mat','like','%'.$this->search.'%')
            ->orWhere('description_mat','like','%'.$this->search.'%');
        })
        ->whereNotIn('id_mat', array_keys($this->currentList))
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);
        
        return view('livewire.admin.labor-cost-edit', compact('materials'));
    }

    public function addToCurrentList(Material $material)
    {
        $this->currentList[$material->id_mat] = [
            'id_mat' => $material->id_mat,
            'code_mat' => $material->code_mat,
            'description_mat' => $material->description_mat,
            'quantity_csm' => 0,
            'unit_of_measurement_mat' => $material->unit_of_measurement_mat
        ];
    }

    public function removeFromCurrentList(Material $material)
    {
        unset($this->currentList[$material->id_mat]);
    }

    public function save()
    {
        $idsToDelete = [];
        foreach ($this->laborCost->customStructureMaterials as $row) 
        {
            $idsToDelete[] = $row->id_csm;
        }
        if(count($idsToDelete) > 0)
        {
            CustomStructureMaterial::destroy($idsToDelete);
        }

        $toSave = [];
        foreach ($this->currentList as $row) 
        {
            $toSave[] = [
                'labor_cost_id' => $this->laborCost->id_lac,
                'material_id_csm' => $row['id_mat'],
                'quantity_csm' => $row['quantity_csm']
            ];
            
        }
        $object = new CustomStructureMaterial();
            $toSave = array_map(function ($data) use ($object) {
                $timestamp = $object->freshTimestampString();
                $data['created_at'] = $timestamp;
                $data['created_by'] = Auth::user()->id_usr;
                return $data;
            }, $toSave);
        CustomStructureMaterial::insert($toSave);
        Session::flash('successMessage', 'Se modificaron los materiales de la estructura '.$this->laborCost->buildingStructure->structure_code_bus);
        return redirect()->route('admin.labor-details.show', $this->laborCost->laborDetail);
    }
}
