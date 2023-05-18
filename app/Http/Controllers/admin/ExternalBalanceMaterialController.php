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
        $array = Excel::import($import, $request->file('file'));
        
        // dd('toc toc',$array->total);
        // foreach ($array as $row) 
        // {
            
        // }
        // dd($import->data);
        // foreach($data as $key => $row)
        // {
        //     dd('toc toc2',$key,$row);
        // }
        
        $response['var1'] = 'var 1';
        $response['var2'] = 'var 2';
        // $response['data'] = $data;
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
