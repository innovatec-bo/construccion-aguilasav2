<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LaborDetail;
use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function internalConciliation(LaborDetail $laborDetail)
    {
        $materials = [];
        foreach ($laborDetail->laborCosts->where('activity_lac','R') as $laborCost)
        {
            foreach ($laborCost->buildingStructure->defaultStructureMaterials as $defaultMaterial)
            {
                if(!isset($materials[$defaultMaterial->material->code_mat]))
                {
                    $materials[$defaultMaterial->material->code_mat] = [
                        'code_mat' =>  $defaultMaterial->material->code_mat,
                        'description_mat' => $defaultMaterial->material->description_mat,
                        'unit_of_measurement_mat' => $defaultMaterial->material->unit_of_measurement_mat,
                        'quantity_dsm' => 0
                    ];
                }
                $materials[$defaultMaterial->material->code_mat]['quantity_dsm'] += $defaultMaterial->quantity_dsm;
            }
        }
        $materials = array_values($materials);

        return view('admin.labor-details.internal-conciliation', compact('materials', 'laborDetail'));
        
    }
}
