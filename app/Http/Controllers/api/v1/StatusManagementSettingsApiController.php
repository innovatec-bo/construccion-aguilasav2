<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Settings\StatusManagementSettings;
use Illuminate\Http\Request;

class StatusManagementSettingsApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StatusManagementSettings $statusManagementSettings)
    {
        return response()->json([
            'response' => true,
            'message' => '',
            'data' => [
                'enable_manual_approvement_for_conciliations' => $statusManagementSettings->enable_manual_approvement_for_conciliations,
                'no_pending_materials_in_cre_for_as_built' => $statusManagementSettings->no_pending_materials_in_cre_for_as_built
            ]
        ],200);
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
}
