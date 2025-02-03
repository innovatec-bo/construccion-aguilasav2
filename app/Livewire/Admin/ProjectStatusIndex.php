<?php

namespace App\Livewire\Admin;

use App\Models\ProjectStatus;
use App\Models\StatusResponsible;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectStatusIndex extends Component
{
    use WithPagination;

    public $search;
    public $sort = 'order_pst';
    public $direction = 'asc';
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $projectStatus = ProjectStatus::when($this->search, function(Builder $query, $search){
        
            $query->where('firstname_usr','like','%'.$this->search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        return view('livewire.admin.project-status-index', compact('projectStatus'));
    }

    public function toggleResponsible($statusResponsibleId)
    {
        $statusResponsible = StatusResponsible::find($statusResponsibleId);
        $statusResponsible->active_sre = $statusResponsible->active_sre == FALSE;
        $statusResponsible->save();
    }
}
