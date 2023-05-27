<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HebergementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'imagePath' => $this->image_path,
            'price' => $this->price,
            'address' => $this->address,
            'phoneNumer' => $this->phone,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'isAvailable' => $this->is_available,
            'site' => new SiteResource($this->whenLoaded('site')),
        ];
    }
}
