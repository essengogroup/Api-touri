<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request):array
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'author' => new UserResource($this->whenLoaded('user')),
            'authorId' => $this->user->id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
