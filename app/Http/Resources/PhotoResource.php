<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'post_id'   => $this->post_id,
            'image_url' => $this->image_url,
            'url'       => $this->url, // Use the URL accessor for proper URL handling
            'caption'   => $this->caption,
            'created_at'=> $this->created_at,
        ];
    }
}
