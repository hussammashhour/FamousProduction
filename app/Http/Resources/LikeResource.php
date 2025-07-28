<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'post_id'    => $this->post_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user'       => $this->whenLoaded('user'),
        ];
    }
}
