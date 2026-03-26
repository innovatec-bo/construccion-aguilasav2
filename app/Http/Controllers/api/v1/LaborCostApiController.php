<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\LaborCostResource;
use App\Models\LaborCost;

class LaborCostApiController extends BaseApiController
{
    public function show($id)
    {
        $laborCost = LaborCost::find($id);
        if (is_null($laborCost)) 
        {
            return $this->sendError('El objeto no existe.');
        }
        $laborCost->laborDetail->applyCustomMaterials();
        $laborCost->refresh();
        return $this->sendResponse(new LaborCostResource($laborCost), 'Detalle del objeto');
    }
}
