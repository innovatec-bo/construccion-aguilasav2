<?php

namespace App\Http\Controllers\api\v1;

use App\CustomLibraries\WorkflowPaginationHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class WorkflowApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 5;
        $page = $request->page;
        $additionalParameters = [];
        $options = [];
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
        if(isset($request->per_page) && $request->per_page <= 500)
        {
            $perPage = $request->per_page;
        }
        $offset = ($page?$page-1:0) * $perPage;//dd($perPage, $offset, 'entry_date_pro','asc', $this->search);
        $paginationHandler = new WorkflowPaginationHandler($perPage, $offset, 'entry_date_pro','desc', $request->search??'', $cols);
        $paginationHandler->setColumnsToShow(['order_pst','cre_fiscal_pro','assign_to_responsible','fiscal_responsible','builder_responsible','project_current_budget','status_log_manual_entry_date','static_days','status_name_pst','manpower_file_id','builder_responsible_id','fiscal_responsible_id','quantity_picked_up_from_cre','materials_delivered_to_cre','quantity_materials_assigned','pending_material_in_cre','stake_responsible']);
        $paginationHandler->setAdditionalParameters($additionalParameters);
        $projects = $paginationHandler->getResponseForDataTable();
        $collection = collect($projects['resultArray']);

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $data = new LengthAwarePaginator($collection, $projects['recordsFiltered'], $perPage, $page, $options);
        return response()->json([
            'response' => true,
            'message' => '',
            'data' => $data
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
