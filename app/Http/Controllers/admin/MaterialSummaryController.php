<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialSummary;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MaterialSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.materials-summary.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show(MaterialSummary $materialsSummary)
    {
        return view('admin.materials-summary.show', compact('materialsSummary'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function loadInitialList()
    {
        return view('admin.materials-summary.load-initial-list');
    }

    public function groupedMovements()
    {
        return view('admin.materials-summary.grouped-movements');
    }

    public function groupedMovementDetails(Project $project)
    {
        return view('admin.materials-summary.grouped-movement-details', compact('project'));
    }

    public function duplicateOutputs()
    {
        set_time_limit(300);
		ini_set('memory_limit','256M');
        $materialsSummary = DB::select("
            select 
                id_pro,
                code_pro,
                id_msu,
                entry_date_msu,
                name_mqt,
                keyword_mqt,
                movement_type_mqt,
                code_mat,
                description_mat,
                quantity_prm,
                concat(id_pro,'-',code_mat) project_material,
                0 balance,
                '' balance_string,
                0 quantity_assigned,
                0 movements
            from 
                mat_materials_summary
            LEFT JOIN mat_projects_materials on id_msu = materials_summary_id_prm
            LEFT JOIN mat_materials_summary_types on id_mqt = summary_type_id_msu
            LEFT join mat_materials on mat_projects_materials.material_id_prm = id_mat
            LEFT JOIN wfl_projects on id_pro = project_id_msu
            where
                deleted_prm != 1
                and mat_projects_materials.deleted_at is null
                and deleted_msu != 1
                and mat_materials_summary.deleted_at is null
                and keyword_mqt in ('materials_picked_up_from_cre', 'materials_delivered_to_builder', 'materials_delivered_to_builder_loan')
                -- and code_pro = 'ro.21.0670'
            
            group by project_id_msu, id_prm
            -- having project_material = '2153-2739'
            order by entry_date_msu
        ");
        // $projects = [];
        // $projectMaterials = [];
        $projectMaterialMemory = [];
        $materialsSummaryToFix = [];
        foreach ($materialsSummary as $row) 
        {
            if($pos = array_search($row->project_material, $projectMaterialMemory) === FALSE)
            {
                $projectMaterialMemory[] = $row->project_material;
                $balance = 0;
                $balanceString = '';
                $movements = 0;
                $materialsSummaryAux = collect($materialsSummary)->where('project_material', $row->project_material)->toArray();
                foreach ($materialsSummaryAux as $key => $item) 
                {
                    switch ($item->movement_type_mqt) 
                   {
                       case 'in':
                            $movements++;
                            $balance += $item->quantity_prm;    
                            $item->balance = $balance;
                            $balanceString .= " (+$item->quantity_prm)";
                            $item->balance_string = $balanceString;
                            $item->movements = $movements;
                            break;
                       case 'out':
                            $movements++;
                            $balance -= $item->quantity_prm;    
                            $item->balance = $balance;
                            $balanceString .= " (-$item->quantity_prm)";
                            $item->balance_string = $balanceString;
                            $item->movements = $movements;
                            break;
                   }
                   $materialsSummaryToFix[] = $item;
                }
            }       
        }
        $materialsSummaryToFix = collect($materialsSummaryToFix)->where('balance','<',0)->where('movements','>',1)->toArray();
        return view('admin.materials-summary.duplicate-outputs', compact('materialsSummary','materialsSummaryToFix'));
    }
}
