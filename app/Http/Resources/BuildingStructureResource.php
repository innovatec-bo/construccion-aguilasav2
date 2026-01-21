<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuildingStructureResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id_bus,
            'structure_code' => $this->structure_code_bus,
            'description' => $this->description_bus,
            'unit_of_measurement' => $this->unit_of_measurement_bus,
            'budget_type' => $this->budget_type_bus,
            'default_structure_materials' => collect(new DefaultStructureMaterialCollection($this->defaultStructureMaterials)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
