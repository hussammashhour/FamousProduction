<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'client_id'       => $this->client_id,
            'photographer_id' => $this->photographer_id,
            'service_id'      => $this->service_id,
            'scheduled_date'  => $this->scheduled_date,
            'status'          => $this->status,
            'comment'         => $this->comment,
            'created_at'      => $this->created_at,
            'service'         => new ServiceResource($this->whenLoaded('service')),
        ];
    }
}
