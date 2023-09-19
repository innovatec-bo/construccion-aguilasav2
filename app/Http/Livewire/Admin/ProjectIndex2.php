<?php

namespace App\Http\Livewire\Admin;

use App\Models\Project;
use App\Models\ProjectStatus;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Settings\StatusManagementSettings;
use Illuminate\Database\Eloquent\Builder;

class ProjectIndex2 extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $projectCode;
    public $sort = 'entry_date_pro';
    public $direction = 'desc';
    public $hiddenStatus;
    public $statusList;
    public $statusSelected;
    public $workAreaSelected;
    public $fiscalList;
    public $fiscalSelected;
    public $enableManualApprovementForConciliations;
    protected $queryString = [
        'projectCode' => ['except' => '', 'as' => 'proyecto'],
        'statusSelected' => ['except' => '', 'as' => 'estado'],
        'workAreaSelected' => ['except' => '', 'as' => 'area'],
        'fiscalSelected' => ['except' => '', 'as' => 'fiscal']
    ];

    protected $listeners = [
        'refreshProjectIndex' => 'render'
    ];

    public function mount()
    {
        $this->enableManualApprovementForConciliations = app(StatusManagementSettings::class)->enable_manual_approvement_for_conciliations;
        $this->hiddenStatus = [
            'schedule',
            'approvement'
        ];   
        $this->statusList = ProjectStatus::whereNotIn('keyword_pst', $this->hiddenStatus)->get();
        $this->fiscalList = User::role('Fiscal')->get();
    }


    public function updating($attribute)
    {
        $toValidate = ['projectCode','statusSelected','workAreaSelected'];
        if (array_search($attribute, $toValidate) !== FALSE) 
        {
            $this->resetPage();
        }
    }

    public function render()
    {
        $projects = Project::
        when($this->projectCode, function(Builder $query, $projectCode){
            $query->where('code_pro','like', '%'.$this->projectCode.'%');
        })
        ->when($this->statusSelected, function(Builder $query, $statusSelected){
            $query->where('status_pro', $this->statusSelected);
        })
        ->when($this->workAreaSelected, function(Builder $query, $workAreaSelected){
            $query->where('work_area_pro', $this->workAreaSelected);
        })
        // ->when($this->fiscalSelected, function(Builder $query, $fiscalSelected){
        //     $query->where('user')
        // })
        ->orderBy($this->sort, $this->direction)->paginate(10);
        return view('livewire.admin.project-index2', compact('projects'));
    }
}
