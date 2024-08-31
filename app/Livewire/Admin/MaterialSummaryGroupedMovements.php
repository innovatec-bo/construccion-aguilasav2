<?php

namespace App\Livewire\Admin;

use App\Models\MaterialSummary;
use App\Models\Project;
use App\Models\SummaryType;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

Class MaterialSummaryGroupedMovements extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id_pro';
    public $direction = 'desc';
    public $deleteId;
    public $materialSummaryTypeSelected;
    public $materialSummaryTypes;
    protected $queryString = ['search' => ['except' => ''], 'materialSummaryTypeSelected' => ['except' => '']];

    public function mount()
    {
        $this->materialSummaryTypes = SummaryType::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $projectStatus = ['in_progress','stopped','paused','completed','project_energized','as_built','conciliation_reception','conciliation_shipment','request_materials_return','cre_return_order','project_return_materials','project_real_budget'];
        $projects = Project::whereHas('status', function(Builder $query)use($projectStatus){
            $query->whereIn('keyword_pst', $projectStatus);
        })
        ->when($this->search, function($query, $search){
            $query->where('code_pro', 'like','%'.$search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        return view('class MaterialSummaryGroupedMovements', compact('projects'));
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
