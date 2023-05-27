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
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
//            'countComments' => $this->comments->count(),
            'activites' => ActiviteResource::collection($this->whenLoaded('activites')),
            'likesCount' => $this->likes_count,
            'sharesCount' => $this->shares_count,
            'guides' => GuideResource::collection($this->whenLoaded('guides')),
            'assurances' => AssuranceResource::collection($this->whenLoaded('assurances')),
            'hebergements' => HebergementResource::collection($this->whenLoaded('hebergements')),
            'restaurants' => RestaurantResource::collection($this->whenLoaded('restaurants')),
            'transports' => TransportResource::collection($this->whenLoaded('transports')),
        ];
    }
}
