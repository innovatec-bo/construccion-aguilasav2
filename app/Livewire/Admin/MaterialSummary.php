<?php

namespace App\Livewire\Admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Resumen de materiales y almacen por proyecto.
 * Cada fila es proyecto + material + tension + estado (ver MaterialSummaryPaginationHandler v5).
 */
class MaterialSummary extends Component
{
    use WithPagination;

    private const PER_PAGE = 5;
    private const DEFAULT_SORT = 'material_id';

    /**
     * Columnas por las que se puede ordenar. Las propiedades publicas de Livewire pueden ser manipuladas
     * desde el navegador, asi que cualquier otro valor cae en DEFAULT_SORT.
     */
    private const SORTABLE = [
        'material_id',
        'project_id',
        'project_code',
        'project_status_name',
        'material_code',
        'material_description',
        'tension_id_prm',
        'status_id_prm',
        'quantity_assigned_materials',
        'quantity_additional_materials',
        'quantity_picked_up_from_cre',
        'quantity_debug_pending_in_cre',
        'pending_material_in_cre',
        'quantity_materials_delivered_to_builder',
        'quantity_materials_delivered_to_cre',
        'quantity_new_materials_returned_by_builder',
        'quantity_materials_returned_by_builder',
        'quantity_entry_by_conciliation_221',
        'quantity_in_warehouse',
        'fiscal_responsible',
    ];

    public $search = "";
    public $sort = self::DEFAULT_SORT;
    public $direction = 'desc';
    public $projectCode;
    public $projectStatusId;
    public $materialCode;

    protected $queryString = [
        'search' => ['except' => ''],
        'projectCode' => ['except' => ''],
        'projectStatusId' => ['except' => ''],
        'materialCode' => ['except' => ''],
        'sort' => ['except' => ''],
        'direction' => ['except' => ''],
    ];

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

    public function resetFilters()
    {
        $this->reset(['materialCode', 'projectStatusId', 'search', 'projectCode']);
        $this->resetPage();
    }

    public function render()
    {
        // El reporte se consulta por proyecto. Con la consulta v5 (una sola pasada) tambien es viable un
        // reporte general: bastaria con quitar esta condicion (probarlo primero en desarrollo).
        $materialSummaries = new LengthAwarePaginator([], 0, self::PER_PAGE);
        if ($this->projectCode)
        {
            $materialSummaries = $this->_paginate();
        }

        $projectStatus = ProjectStatus::orderBy('order_pst')->get();
        return view('livewire.admin.material-summary', compact('materialSummaries', 'projectStatus'));
    }

    public function _paginate($options = [])
    {
        $page = max(1, (int)Paginator::resolveCurrentPage());
        $offset = ($page - 1) * self::PER_PAGE;

        $project = Project::where('code_pro', $this->projectCode)->where('deleted_pro', '!=', 1)->first();
        if (!$project)
        {
            // codigo inexistente: sin resultados (no se consulta nada)
            return new LengthAwarePaginator([], 0, self::PER_PAGE, $page, $options);
        }

        $additionalParameters = ['project-id' => $project->id_pro];
        if ($this->projectStatusId)
        {
            $additionalParameters['project-status-id'] = $this->projectStatusId;
        }
        if ($this->materialCode)
        {
            $additionalParameters['material-codes'] = $this->materialCode;
        }

        $sort = in_array($this->sort, self::SORTABLE, true) ? $this->sort : self::DEFAULT_SORT;
        $direction = $this->direction === 'asc' ? 'asc' : 'desc';

        $paginationHandler = new MaterialSummaryPaginationHandler(
            self::PER_PAGE,
            $offset,
            $sort,
            $direction,
            (string)$this->search,
            ['material_description']
        );
        $paginationHandler->setAdditionalParameters($additionalParameters);
        $result = $paginationHandler->getResponseForDataTable();

        return new LengthAwarePaginator(
            collect($result['resultArray']),
            $result['recordsFiltered'],
            self::PER_PAGE,
            $page,
            $options
        );
    }

    public function order($sort)
    {
        if (!in_array($sort, self::SORTABLE, true))
        {
            return;
        }

        if ($this->sort == $sort)
        {
            $this->direction = $this->direction == 'desc' ? 'asc' : 'desc';
        }
        else
        {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
}