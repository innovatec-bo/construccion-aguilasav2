<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Settings\StatusManagementSettings;
use Illuminate\Http\Request;

class StatusManagementSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StatusManagementSettings $statusManagementSettings)
    {
        // dd($statusManagementSettings->enable_manual_approvement_for_conciliations);
        return view('admin.settings.status-management.index');
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StatusManagementSettings $statusManagementSettings)
    {
        return view('admin.settings.status-management.edit', compact('statusManagementSettings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings\StatusManagementSettings statusManagementSettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatusManagementSettings $statusManagementSettings)
    {
        $statusManagementSettings->enable_manual_approvement_for_conciliations = $request->input('enable_manual_approvement_for_conciliations');
        $statusManagementSettings->no_pending_materials_in_cre_for_as_built = $request->input('no_pending_materials_in_cre_for_as_built');
        $statusManagementSettings->save();
        
        return redirect()->back();
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
