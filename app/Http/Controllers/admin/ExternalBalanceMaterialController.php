<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\ExternalBalanceMaterialDataImport;
use App\Imports\ExternalBalanceMaterialImport;
use App\Models\ExternalBalanceMaterial;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class ExternalBalanceMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.external-balance-material.index', ['only' => ['index']]);
        $this->middleware('permission:admin.external-balance-material.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin.external-balance-material.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin.external-balance-material.show', ['only' => ['show']]); 
        $this->middleware('permission:admin.external-balance-material.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.external-balance-material.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.external-balance-material.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        set_time_limit(300);
        ini_set('memory_limit', '750M');
        
        $import = new ExternalBalanceMaterialImport();
        $import->onlySheets(1);
        Excel::import($import, $request->file('file'));
        
        $data = ExternalBalanceMaterial::limit(8587)->get();
        
        $totalRecords = $data->count();

        $totalProjects = $data->groupBy('Proyecto')->map(function ($project) {
            return $project->count();
        })->count();

        $totalMaterials = $data->groupBy('Material')->map(function ($material) {
            return $material->count();
        })->count();

        $records221And222 = $data->groupBy('CMv')->map(function ($project) {
            return $project->count();
        });
        $response['totalMaterials'] = $totalMaterials;
        $response['totalRecords'] = $totalRecords;
        $response['totalProjects'] = $totalProjects;
        $response['records221And222'] = $records221And222;
        return response()->json(
            $response
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExternalBalanceMaterial  $externalBalanceMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(ExternalBalanceMaterial $externalBalanceMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExternalBalanceMaterial  $externalBalanceMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(ExternalBalanceMaterial $externalBalanceMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExternalBalanceMaterial  $externalBalanceMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExternalBalanceMaterial $externalBalanceMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExternalBalanceMaterial  $externalBalanceMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExternalBalanceMaterial $externalBalanceMaterial)
    {
        //
    }
}
