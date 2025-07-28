<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
        public function toArray($request)
        {
            return [
                'id'           => $this->id,
                'file_path'    => $this->file_path,
                'url'          => $this->url,
                'original_name'=> $this->original_name,
            ];
        }
}
