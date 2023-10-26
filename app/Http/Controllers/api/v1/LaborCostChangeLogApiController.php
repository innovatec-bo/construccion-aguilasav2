<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\LaborCostChangeLog;
use Illuminate\Http\Request;

class LaborCostChangeLogApiController extends BaseApiController
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $laborCostChangeLog = new LaborCostChangeLog();
        $laborCostChangeLog->labor_cost_id = $request->get('labor_cost_id');
        $laborCostChangeLog->quantity_applied = $request->get('quantity_applied');
        $laborCostChangeLog->quantity_from = $request->get('quantity_from');
        $laborCostChangeLog->quantity_to = ($request->get('quantity_from')) + ($request->get('quantity_applied'));
        $laborCostChangeLog->created_by = $request->get('user_id');
        $laborCostChangeLog->save();

        return response()->json([
            'response' => true,
            'message' => 'ok',
            'data' => ['logId' => $laborCostChangeLog->id]
        ],200);
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
