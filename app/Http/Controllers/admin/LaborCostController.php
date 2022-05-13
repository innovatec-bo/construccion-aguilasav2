<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LaborCost;
use Illuminate\Http\Request;

class LaborCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\LaborCost  $laborCost
     * @return \Illuminate\Http\Response
     */
    public function show(LaborCost $laborCost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LaborCost  $laborCost
     * @return \Illuminate\Http\Response
     */
    public function edit(LaborCost $laborCost)
    {
        // dd($laborCost->laborDetail->project->code_pro,$laborCost->laborDetail->hasCustomMaterials);
        $laborCost->laborDetail->applyCustomMaterials();
        return view('admin.labor-costs.edit', compact('laborCost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LaborCost  $laborCost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LaborCost $laborCost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LaborCost  $laborCost
     * @return \Illuminate\Http\Response
     */
    public function destroy(LaborCost $laborCost)
    {
        //
    }
}
