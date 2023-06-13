<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LaborCostLog;
use Illuminate\Http\Request;

class LaborCostLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.labor-cost-log.index');
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
     * @param  \App\Models\LaborCostLog  $laborCostLog
     * @return \Illuminate\Http\Response
     */
    public function show(LaborCostLog $laborCostLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LaborCostLog  $laborCostLog
     * @return \Illuminate\Http\Response
     */
    public function edit(LaborCostLog $laborCostLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LaborCostLog  $laborCostLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LaborCostLog $laborCostLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LaborCostLog  $laborCostLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(LaborCostLog $laborCostLog)
    {
        //
    }
}
