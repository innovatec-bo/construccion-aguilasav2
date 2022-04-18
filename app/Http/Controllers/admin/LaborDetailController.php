<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LaborDetail;
use Illuminate\Http\Request;

class LaborDetailController extends Controller
{
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
        return view('admin.labor-details.show', compact('laborDetail'));
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
}
