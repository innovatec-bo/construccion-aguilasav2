<?php

namespace App\Http\Livewire\admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\CustomLibraries\WorkflowPaginationHandler;
use App\Exports\UsersExport;
use App\Models\Project;
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
    public $sort = 'id_mat';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => ''], 'groupByProject' => ['except' => false], 'projectCode' => ['except' => '']];
    public $usersToExport;
    public $groupByProject = false;
    public $projectCode;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingProjectCode()
    {
        $this->resetPage();
    }

    public function render()
    {
        $materialSummaries = $this->_paginate();
        return view('livewire.admin.material-summary', compact('materialSummaries'));
    }

    public function _paginate($options = [])
    {
        $perPage = 5;
        $page = $this->page;
        $additionalParameters = [];
        $cols = [
            'project_code',
            // 'status_name_pst',
            // 'system_pro',
            // 'cre_fiscal_pro',
            // 'stake_responsible',
            // 'assign_to_responsible',
            // 'address_pro',
            // 'project_current_budget'
        ];
        // $cols = [];  
        $offset = ($page?$page-1:0) * $perPage;
        $paginationHandler = new MaterialSummaryPaginationHandler($perPage, $offset, 'material_id','desc', $this->search, $cols);
        // $additionalParameters['project-id'] = '1067';
        $additionalParameters['grouping-criteria'] = ' project_id_msu, material_id_prm, status_id_prm ';
        if($this->groupByProject)
        {
            $additionalParameters['grouping-criteria'] = ' project_id_msu ';
        }
        if($this->projectCode)
        {
            $project = Project::where('code_pro', $this->projectCode)->where('deleted_pro','!=',1)->first();
            $additionalParameters['project-id'] = 000;
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
