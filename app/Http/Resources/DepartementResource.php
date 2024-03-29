<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'imagePath' => url($this->image_path),
            'sites' => SiteResource::collection($this->whenLoaded('sites')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
