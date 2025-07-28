<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'photo_id'    => $this->photo_id,
            'created_by'  => $this->created_by,
            'announcement_type'   => $this->announcement_type,
            'announcement_status' => $this->announcement_status,
            'body'        => $this->body,
            'published_at'=> $this->published_at,
            'created_at'  => $this->created_at,
        ];
    }
}
