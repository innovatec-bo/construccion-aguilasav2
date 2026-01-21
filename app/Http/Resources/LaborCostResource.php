<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaborCostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_lac' => $this->id_lac,
            'labor_detail_id_lac' => $this->labor_detail_id_lac,
            'building_structure_id_lac' => $this->building_structure_id_lac,
            'activity_lac' => $this->activity_lac,
            'execution_lac' => $this->execution_lac,
            'quantity_lac' => $this->quantity_lac,
            'unit_price_lac' => $this->unit_price_lac,
            'is_additional_lac' => $this->is_additional_lac,
            'default_materials' => collect(new CustomStructureMaterialCollection($this->customStructureMaterials)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
