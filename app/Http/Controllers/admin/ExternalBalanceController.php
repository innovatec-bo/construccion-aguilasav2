<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\ExternalBalanceMaterialImport;
use App\Models\ExternalBalance;
use App\Models\ExternalBalanceMaterial;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExternalBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.external-balance.index');
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
        set_time_limit(300);
        ini_set('memory_limit', '750M');
        
        $import = new ExternalBalanceMaterialImport();
        $import->onlySheets(1);
        $data = Excel::toArray($import, $request->file('file'));
        
        $externalBalanceId = ExternalBalance::saveData($data);
        
        $response['externalBalanceId'] = $externalBalanceId;
        return response()->json(
            $response
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExternalBalance  $externalBalance
     * @return \Illuminate\Http\Response
     */
    public function show(ExternalBalance $externalBalance)
    {
        return view('admin.external-balance.show', compact('externalBalance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExternalBalance  $externalBalance
     * @return \Illuminate\Http\Response
     */
    public function edit(ExternalBalance $externalBalance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExternalBalance  $externalBalance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExternalBalance $externalBalance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExternalBalance  $externalBalance
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExternalBalance $externalBalance)
    {
        //
    }
}
