<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BuildingStructure;
use App\Models\Project;
use Illuminate\Http\Request;

class BuildingStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.building-structures.index');
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
     * @param  \App\Models\BuildingStructure  $buildingStructure
     * @return \Illuminate\Http\Response
     */
    public function show(BuildingStructure $buildingStructure)
    {
        return view('admin.building-structures.show', compact('buildingStructure'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuildingStructure  $buildingStructure
     * @return \Illuminate\Http\Response
     */
    public function edit(BuildingStructure $buildingStructure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuildingStructure  $buildingStructure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuildingStructure $buildingStructure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuildingStructure  $buildingStructure
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuildingStructure $buildingStructure)
    {
        //
    }

    public function uploadDefaultMaterials()
    {
        return view('admin.building-structures.upload-default-materials');
    }
}
