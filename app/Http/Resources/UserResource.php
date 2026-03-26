<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'status' => new UserStatusResource($this->status),
            'app_token' => $this->app_token,
            'roles' => $this->roles,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
