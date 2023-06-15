<?php

namespace App\Http\Livewire\Admin;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ProjectIndex2 extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $projectCode;
    public $sort = 'entry_date_pro';
    public $direction = 'desc';
    protected $queryString = ['projectCode' => ['except' => '', 'as' => 'proyecto']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::
        when($this->projectCode, function(Builder $query, $projectCode){
            $query->where('code_pro', $this->projectCode);
        })
        ->orderBy($this->sort, $this->direction)->paginate(10);
        return view('livewire.admin.project-index2', compact('projects'));
    }
}
