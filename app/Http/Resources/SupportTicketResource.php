<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketResource extends JsonResource
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
            'subject'    => $this->subject,
            'description'=> $this->description,
            'status'     => $this->status,
            'priority'   => $this->priority,
            'closed_at'  => $this->closed_at,
            'created_at' => $this->created_at,
            'replies'    => SupportTicketReplyResource::collection($this->whenLoaded('replies')),
            'attachments'=> AttachmentResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
