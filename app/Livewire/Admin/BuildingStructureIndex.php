<?php

namespace App\Livewire\Admin;

use App\Models\BuildingStructure;
use App\Models\MaterialSummary;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

Class BuildingStructureIndex extends Component
{
    use WithPagination;
    
    public $search;
    public $sort = 'id_bus';
    public $direction = 'desc';
    public $deleteId;
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $buildingStructureList = BuildingStructure::where(function(Builder $query){
            if(isset($this->search) && $this->search != "")
                $query->where('description_bus','like','%'.$this->search.'%')
                ->orWhere('structure_code_bus',$this->search);
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        return view('livewire.admin.building-structure-index', compact('buildingStructureList'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) 
        {
            if ($this->direction == 'desc') 
            {
                $this->direction = 'asc';
            } 
            else 
            {
                $this->direction = 'desc';
            }
            
        } 
        else 
        {
            $this->sort = $sort;
            $this->direction = 'asc';
        }   
    }

    public function delete(MaterialSummary $materialSummary)
    {
        $materialSummary->delete();
        $this->dispatch('alert',['successMessage', 'Movimiento eliminado exitosamente.']);
        return back();
    }
}
