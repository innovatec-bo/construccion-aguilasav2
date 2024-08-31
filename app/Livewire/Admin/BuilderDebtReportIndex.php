<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use App\Models\ProjectStatus;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use PhpParser\Node\Expr\BinaryOp\Concat;

Class BuilderDebtReportIndex extends Component
{
    use WithPagination;
    
    public $search;
    public $sort = 'id_pro';
    public $direction = 'asc';
    public $deleteId = '';
    public $builderSelected;
    public $statusSelected;
    public $keywordsStatusToVerify;
    // public $builders;
    protected $queryString = 
    [
        'search' => ['except' => ''],
        'builderSelected' => ['except' => ''],
        'statusSelected' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->keywordsStatusToVerify = ['in_progress','stopped','paused','completed','as_built','conciliation_reception','conciliation_shipment','request_materials_return','cre_return_order','project_return_materials','project_real_budget'];
    }

    public function render()
    {
        $statusToVerify = ProjectStatus::whereIn('keyword_pst', $this->keywordsStatusToVerify)->orderBy('order_pst')->get()->pluck('status_name_pst','id_pst')->prepend('--Todos--','');
        $builders = User::role('builder')->orderBy('firstname_usr','asc')->get()->pluck('full_name','id_usr')->prepend('--Todos--','');
        $projects = Project::whereHas('status', function(Builder $query){
            $query->whereIn('keyword_pst',$this->keywordsStatusToVerify);
        });
        if(isset($this->search) && $this->search != "")
        {
            $projects = $projects->where('code_pro','like','%'.$this->search.'%');
        }
        if(isset($this->builderSelected) && $this->builderSelected != "")
        {
            $projects = $projects->whereHas('statusLogResponsibles', function(Builder $query){
                $query->whereHas('responsible', function(Builder $query){
                    $query->where('user_id_sre', $this->builderSelected);
                });
            });
        }
        if(isset($this->statusSelected) && $this->statusSelected != "")
        {
            $projects = $projects->where('status_pro', $this->statusSelected);
        }
        $projects = $projects
        ->whereHas('laborDetailDesign', function(Builder $query){
            $query->whereHas('laborCosts', function(Builder $query){
                $query->where('activity_lac', 'R');
            });
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        return view('livewire.admin.builder-debt-report-index', compact('projects','builders','statusToVerify'));
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
