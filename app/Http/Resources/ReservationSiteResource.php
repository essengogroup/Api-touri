<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationSiteResource extends JsonResource
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
            "id" => $this->id,
            "site_id" => $this->site_id,
            "user_id" => $this->user_id,
            "site_date_id" => $this->site_date_id,
            "price" => $this->price,
            "nb_personnes" => $this->nb_personnes,
            "is_paid" => $this->is_paid,
            "status" => $this->status,
            "commentaire" => $this->commentaire,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "site_date" => new SiteDateResource($this->siteDate),
            "site" => new SiteResource($this->site),
            "user" => new UserResource($this->user),
            "activites" => ActiviteResource::collection($this->activites),
        ];
        // return parent::toArray($request);
    }
}
