<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActiviteResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'image_path' => url($this->image_path),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sites' => $this->sites->map(function ($site) {
                return [
                    'id' => $site->id,
                    'name' => $site->name,
                    'description' => $site->description,
                    'price' => $site->price,
                    'latitude' => $site->latitude,
                    'longitude' => $site->longitude,
                    'created_at' => $site->created_at,
                    'updated_at' => $site->updated_at
                ];
            })
        ];
    }
}
