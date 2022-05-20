<?php

namespace App\Http\Livewire\admin;

use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class MaterialSummaryGroupedMovementDetails extends Component
{
    use WithPagination;
    public $project;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id_mat';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $materialSummaries = $this->project->materialSummaries()
        ->when($this->search, function($query){
            $query->whereHas('projectMaterials', function(Builder $query){
                $query->whereHas('material', function(Builder $query){
                    $query->where('code_mat',$this->search);
                            // ->orWhere('name_mat','like','%'.$this->search.'%')
                            // ->orWhere('description_mat','like','%'.$this->search.'%');
                });
            });
        })
        ->get();
        return view('livewire.admin.material-summary-grouped-movement-details', compact('materialSummaries'));
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
}
