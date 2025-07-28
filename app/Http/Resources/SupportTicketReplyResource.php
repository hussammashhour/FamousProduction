<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketReplyResource extends JsonResource
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
                'message'    => $this->message,
                'is_internal'=> $this->is_internal,
                'created_at' => $this->created_at,
                'attachments'=> AttachmentResource::collection($this->whenLoaded('attachments')),
            ];
        }
}
