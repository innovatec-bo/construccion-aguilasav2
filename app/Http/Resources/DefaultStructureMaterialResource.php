<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultStructureMaterialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id_dms,
            'material' => new MaterialResource($this->material),
            'quantity' => $this->quantity_dms,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
