<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
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
            'price' => $this->price,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'departement' => $this->departement,
            'medias' => MediaResource::collection($this->medias),
            'siteDates' => SiteDateResource::collection($this->siteDates),
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
            })
        ];
    }
}
