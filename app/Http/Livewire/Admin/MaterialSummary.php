<?php

namespace App\Http\Livewire\admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\CustomLibraries\WorkflowPaginationHandler;
use App\Exports\UsersExport;
use App\Models\Project;
use App\Models\ProjectStatus;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class MaterialSummary extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search = "";
    public $sort = 'material_id';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = [
        'search' => ['except' => ''], 
        'groupByProject' => ['except' => false], 
        'projectCode' => ['except' => ''],
        'projectStatusId' => ['except' => ''],
        'materialCode' => ['except' => ''],
        'sort' => ['except' => ''],
        'direction' => ['except' => ''],
    ];
    public $usersToExport;
    public $groupByProject = false;
    public $projectCode;
    public $projectStatusId;
    public $materialCode;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingProjectCode()
    {
        $this->resetPage();
    }
    public function updatingProjectStatusId()
    {
        $this->resetPage();
    }
    
    public function updatingMaterialCode()
    {
        $this->resetPage();
    }

    public function updatingGroupByProject()
    {
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->reset(['groupByProject','materialCode','projectStatusId','search','projectCode']);
    }

    public function render()
    {
        $materialSummaries = [];
        if($this->projectCode)
        {
            $materialSummaries = $this->_paginate();
        }
        
        $projectStatus = ProjectStatus::orderBy('order_pst')->get();
        return view('livewire.admin.material-summary', compact('materialSummaries', 'projectStatus'));
    }

    public function _paginate($options = [])
    {
        $perPage = 5;
        $page = $this->page;
        $additionalParameters = [];
        $cols = [
            'material_description'
        ];
        // $cols = [];  
        $offset = ($page?$page-1:0) * $perPage;
        $paginationHandler = new MaterialSummaryPaginationHandler($perPage, $offset, $this->sort, $this->direction, $this->search, $cols);
        // $additionalParameters['project-id'] = '1067';
        $additionalParameters['grouping-criteria'] = ' project_id_msu, material_id_prm, status_id_prm ';
        if($this->groupByProject)
        {
            $additionalParameters['grouping-criteria'] = ' project_id_msu ';
        }
        if($this->projectStatusId)
        {
            $additionalParameters['project-status-id'] = $this->projectStatusId;
        }
        if($this->materialCode)
        {
            $additionalParameters['material-codes'] = $this->materialCode;
        }
        if($this->projectCode)
        {
            $project = Project::where('code_pro', $this->projectCode)->where('deleted_pro','!=',1)->first();
            $additionalParameters['project-id'] = 10000000;
            if($project)
            {
                $additionalParameters['project-id'] = $project->id_pro;
            }
            
        }
        // dd($additionalParameters);
        $paginationHandler->setAdditionalParameters($additionalParameters);
        $projects = $paginationHandler->getResponseForDataTable();
        $collection = collect($projects['resultArray']);

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        return new LengthAwarePaginator($collection, $projects['recordsFiltered'], $perPage, $page, $options);
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

    public function export()
    {
        $export = new UsersExport($this->usersToExport);
        return Excel::download($export, 'Usuarios.xlsx');
    }
}
