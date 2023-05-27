<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullName' => $this->full_name,
            'email' => $this->email,
            'phoneNumber' => $this->phone,
            'profilePicture' => $this->profile_picture ? url($this->profile_picture) : null,
            'address' => $this->address,
            'createdAt' => $this->created_at,
            'updated_at' => $this->updated_at,
            'roles' => $this->roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                ];
            }),
        ];
    }
}
