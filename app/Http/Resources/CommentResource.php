<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'content'    => $this->comment_text,
            'user_id'    => $this->user_id,
            'post_id'    => $this->post_id,
            'photo_id'   => $this->photo_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user'       => $this->whenLoaded('user'),
        ];
    }
}
