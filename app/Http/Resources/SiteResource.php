<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'departement' => new DepartementResource($this->whenLoaded('departement')),
            'medias' => MediaResource::collection($this->medias),
            /*'siteDates' => SiteDateResource::collection($this->whenLoaded('siteDates')),
            'activites' => $this->activites->map(function ($activite) {
                return [
                    'id' => $activite->id,
                    'name' => $activite->name,
                    'description' => $activite->description,
                    'image_path' => url($activite->image_path),
                    'created_at' => $activite->created_at,
                    'updated_at' => $activite->updated_at,
                    'pivot' => [
                        'type' => $activite->pivot->type,
                        'price' => $activite->pivot->price
                    ]
                ];
            })*/
        ];
    }
}
