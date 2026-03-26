<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Resources\BuildingStructureResource;
use App\Models\BuildingStructure;

class BuildingStructureApiController extends BaseApiController
{
    public function show($id)
    {
        $buildingStructure = BuildingStructure::find($id);
        if (is_null($buildingStructure)) 
        {
            return $this->sendError('La estructura no existe.');
        }
        return $this->sendResponse(new BuildingStructureResource($buildingStructure), 'Detalle de la estructura');
    }
}
