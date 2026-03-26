<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_mat' => $this->id_mat,
            'code_mat' => $this->code_mat,
            'name_mat' => $this->name_mat,
            'description_mat' => $this->description_mat,
            'unit_of_measurement_mat' => $this->unit_of_measurement_mat,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
