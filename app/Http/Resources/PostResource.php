<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'user_id'     => $this->user_id,
            'title'       => $this->title,
            'description' => $this->description,
            'caption'     => $this->description, // For compatibility with Gallery
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'user'        => $this->whenLoaded('user'),
            'photos'      => PhotoResource::collection($this->whenLoaded('photos')),
            'comments'    => CommentResource::collection($this->whenLoaded('comments')),
            'likes'       => LikeResource::collection($this->whenLoaded('likes')),
            'tags'        => TagResource::collection($this->whenLoaded('tags')),
            'likes_count' => $this->when(isset($this->likes_count), $this->likes_count),
            'comments_count' => $this->when(isset($this->comments_count), $this->comments_count),
            'is_liked'    => $this->when(isset($this->is_liked), $this->is_liked),
        ];
    }
}
