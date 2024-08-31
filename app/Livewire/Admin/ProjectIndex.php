<?php

namespace App\Livewire\Admin;

use App\CustomLibraries\WorkflowPaginationHandler;
use App\Exports\UsersExport;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

Class ProjectIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search = "";
    public $sort = 'id_usr';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];
    public $usersToExport;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $projects = $this->_paginate();
        return view('class ProjectIndex', compact('projects'));
    }

    public function _paginate($options = [])
    {
        $perPage = 10;
        $page = $this->page;
        $additionalParameters = [];
        $cols = [
            'code_pro',
            'status_name_pst',
            'system_pro',
            'cre_fiscal_pro',
            'stake_responsible',
            'assign_to_responsible',
            'address_pro',
            'project_current_budget'
        ];
        $offset = ($page?$page-1:0) * $perPage;//dd($perPage, $offset, 'entry_date_pro','asc', $this->search);
        $paginationHandler = new WorkflowPaginationHandler($perPage, $offset, 'entry_date_pro','desc', $this->search, $cols);
		$paginationHandler->setColumnsToShow(['order_pst','cre_fiscal_pro','assign_to_responsible','fiscal_responsible','builder_responsible','project_current_budget','status_log_manual_entry_date','static_days','status_name_pst','manpower_file_id','builder_responsible_id','fiscal_responsible_id','quantity_picked_up_from_cre','materials_delivered_to_cre','quantity_materials_assigned','pending_material_in_cre','stake_responsible']);
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
