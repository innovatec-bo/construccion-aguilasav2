<?php

namespace App\Http\Controllers\admin;

use App\Exports\LaborDetailExport;
use App\Exports\LaborDetailInternalConciliationCreFormatExport;
use App\Exports\LaborDetailInternalConciliationExport;
use App\Http\Controllers\Controller;
use App\Models\LaborDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

class LaborDetailController extends Controller
{
    private $_internalConciliation;
    private $_previousRoute;
    private $_previousQueryString;
    public function __construct()
    {
        $url = url()->previous();
        $this->_previousRoute = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $parsedUrl = parse_url($url);
        $this->_previousQueryString = $parsedUrl['query']??'';
        // $parsedUrl['post']; // www.example.com
        // $parsedUrl['path']; // /posts
        // $parsedUrl['query']; // param=val&param2=val
        // dd($parsedUrl);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.labor-details.index');
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
     * @param  \App\Models\LaborDetail  $laborDetail
     * @return \Illuminate\Http\Response
     */
    public function show(LaborDetail $laborDetail)
    {
        $laborDetail->applyCustomMaterials();
        parse_str($this->_previousQueryString, $previousQueryString);
        return view('admin.labor-details.show', compact('laborDetail','previousQueryString'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LaborDetail  $laborDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(LaborDetail $laborDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LaborDetail  $laborDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LaborDetail $laborDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LaborDetail  $laborDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(LaborDetail $laborDetail)
    {
        //
    }

    public function internalConciliation(LaborDetail $laborDetail)
    {
        $previousRoute = $this->_previousRoute;
        $laborDetail->applyCustomMaterials();
        //builder_returns_materials
        $returnedMaterials = [];
        foreach ($laborDetail->project->materialSummaries->whereIn('summary_type_id_msu',[18]) as $key => $materialSummary) 
        {
            foreach ($materialSummary->projectMaterials as $key => $projectMaterial) 
            {
                //verify that material status is 'Old material'
                if($projectMaterial->status->code_mst == 'MEO')
                {
                    if(!isset($returnedMaterials[$projectMaterial->material->code_mat]))
                    {
                        $returnedMaterials[$projectMaterial->material->code_mat] = [
                            'code_mat' => $projectMaterial->material->code_mat,
                            'description_mat' => $projectMaterial->material->description_mat,
                            'unit_of_measurement_mat' => $projectMaterial->material->unit_of_measurement_mat,
                            'quantity_prm' => 0,
                            'quantity_csm' => 0,
                            'structures' => ''
                        ];
                    }
                    $returnedMaterials[$projectMaterial->material->code_mat]['quantity_prm'] += $projectMaterial->quantity_prm;
                }
            }
        }

        $materialsToBeReturned = [];
        foreach ($laborDetail->laborCosts->where('activity_lac','R') as $laborCost)
        {
            $totalCustomMaterials = $laborCost->customStructureMaterials->count();
            foreach ($laborCost->customStructureMaterials as $customMaterial)
            {
                if(!isset($materialsToBeReturned[$customMaterial->material->code_mat]))
                {
                    $materialsToBeReturned[$customMaterial->material->code_mat] = [
                        'code_mat' =>  $customMaterial->material->code_mat,
                        'description_mat' => $customMaterial->material->description_mat,
                        'unit_of_measurement_mat' => $customMaterial->material->unit_of_measurement_mat,
                        'quantity_csm' => 0,
                        'quantity_prm' => 0,
                        'structures' => ''
                    ];
                }
                $materialsToBeReturned[$customMaterial->material->code_mat]['quantity_csm'] += ($customMaterial->quantity_csm * $laborCost->quantity_lac) ;
                $materialsToBeReturned[$customMaterial->material->code_mat]['structures'] .= $laborCost->buildingStructure->structure_code_bus.', ';
            }
        }

        //First loop materials to be returned, this is the control list
        foreach ($materialsToBeReturned as $materialCode => &$material) 
        {
            $material['quantity_prm'] = 0;
            if(isset($returnedMaterials[$materialCode]))
            {
                $material['quantity_prm'] = $returnedMaterials[$materialCode]['quantity_prm'];
                unset($returnedMaterials[$materialCode]);
            }
        }
        $materialsToBeReturned = array_values($materialsToBeReturned);
        $returnedMaterials = array_values($returnedMaterials);
        $this->_internalConciliation['materialsToBeReturned'] = $materialsToBeReturned;
        $this->_internalConciliation['returnedMaterials'] = $returnedMaterials;
        return view('admin.labor-details.internal-conciliation', compact('materialsToBeReturned','returnedMaterials', 'laborDetail', 'previousRoute'));   
    }

    public function internalConciliationBuilder(LaborDetail $laborDetail)
    {
        $previousRoute = $this->_previousRoute;
        $laborDetail->applyCustomMaterials();
        //builder_returns_materials
        $returnedMaterials = [];
        foreach ($laborDetail->project->materialSummaries->whereIn('summary_type_id_msu',[18]) as $key => $materialSummary) 
        {
            foreach ($materialSummary->projectMaterials as $key => $projectMaterial) 
            {
                //verify that material status is 'Old material'
                if($projectMaterial->status->code_mst == 'MEO')
                {
                    if(!isset($returnedMaterials[$projectMaterial->material->code_mat]))
                    {
                        $returnedMaterials[$projectMaterial->material->code_mat] = [
                            'code_mat' => $projectMaterial->material->code_mat,
                            'description_mat' => $projectMaterial->material->description_mat,
                            'unit_of_measurement_mat' => $projectMaterial->material->unit_of_measurement_mat,
                            'quantity_prm' => 0,
                            'quantity_csm' => 0,
                            'structures' => ''
                        ];
                    }
                    $returnedMaterials[$projectMaterial->material->code_mat]['quantity_prm'] += $projectMaterial->quantity_prm;
                }
            }
        }

        $materialsToBeReturned = [];
        foreach ($laborDetail->laborCosts->where('activity_lac','R') as $laborCost)
        {
            $totalCustomMaterials = $laborCost->customStructureMaterials->count();
            foreach ($laborCost->customStructureMaterials as $customMaterial)
            {
                if(!isset($materialsToBeReturned[$customMaterial->material->code_mat]))
                {
                    $materialsToBeReturned[$customMaterial->material->code_mat] = [
                        'code_mat' =>  $customMaterial->material->code_mat,
                        'description_mat' => $customMaterial->material->description_mat,
                        'unit_of_measurement_mat' => $customMaterial->material->unit_of_measurement_mat,
                        'quantity_csm' => 0,
                        'quantity_prm' => 0,
                        'structures' => ''
                    ];
                }
                $materialsToBeReturned[$customMaterial->material->code_mat]['quantity_csm'] += ($customMaterial->quantity_csm * $laborCost->quantity_lac) ;
                $materialsToBeReturned[$customMaterial->material->code_mat]['structures'] .= $laborCost->buildingStructure->structure_code_bus.', ';
            }
        }

        //First loop materials to be returned, this is the control list
        foreach ($materialsToBeReturned as $materialCode => &$material) 
        {
            $material['quantity_prm'] = 0;
            if(isset($returnedMaterials[$materialCode]))
            {
                $material['quantity_prm'] = $returnedMaterials[$materialCode]['quantity_prm'];
                unset($returnedMaterials[$materialCode]);
            }
        }
        $materialsToBeReturned = array_values($materialsToBeReturned);
        $returnedMaterials = array_values($returnedMaterials);

        return view('admin.labor-details.internal-conciliation-builder', compact('materialsToBeReturned','returnedMaterials', 'laborDetail', 'previousRoute'));   
    }

    public function internalConciliationCreFormat(LaborDetail $laborDetail)
    {
        // $laborDetail->internalConciliationCreFormat();
        return view('admin.labor-details.internal-conciliation-cre-format', compact('laborDetail'));   
    }

    public function export(LaborDetail $laborDetail)
    {
        $export = new LaborDetailExport($laborDetail->laborCosts);
        return Excel::download($export, 'Mano de obra en '.$laborDetail->environment['label'].' '.$laborDetail->project->code_pro.' - '.date('Y.m.d_H.i.s').'.xlsx');
    }

    public function exportInternalConciliation(LaborDetail $laborDetail)
    {
        $export = new LaborDetailInternalConciliationExport($laborDetail->laborCosts);
        return Excel::download($export, 'Conciliacion interna en '.$laborDetail->environment['label'].' '.$laborDetail->project->code_pro.' - '.date('Y.m.d_H.i.s').'.xlsx');
    }

    public function exportInternalConciliationCreFormat(LaborDetail $laborDetail)
    {
        $export = new LaborDetailInternalConciliationCreFormatExport($laborDetail->internalConciliationCreFormat());
        return Excel::download($export, 'Conciliacion interna formato CRE en '.$laborDetail->environment['label'].' '.$laborDetail->project->code_pro.' - '.date('Y.m.d_H.i.s').'.xlsx');
    }
}
