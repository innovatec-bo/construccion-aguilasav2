<?php

namespace App\Http\Livewire\Admin;

use App\Models\Material;
use Livewire\Component;
use Livewire\WithPagination;

class LaborCostEdit extends Component
{
    use WithPagination;

    public $laborCost;
    public $search;
    public $sort = 'description_mat';
    public $direction = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $materials = Material::Where(function($query){
            $query->where('code_mat','like','%'.$this->search.'%')
            ->orWhere('name_mat','like','%'.$this->search.'%')
            ->orWhere('description_mat','like','%'.$this->search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);
        
        return view('livewire.admin.labor-cost-edit', compact('materials'));
    }
}
