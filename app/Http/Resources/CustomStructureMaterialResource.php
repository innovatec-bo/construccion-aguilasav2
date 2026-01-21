<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomStructureMaterialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_csm' => $this->id_csm,
            'labor_cost_id' => $this->labor_cost_id,
            'material' => new MaterialResource($this->material),
            'quantity_csm' => $this->quantity_csm,
            'project_id_csm' => $this->project_id_csm,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
