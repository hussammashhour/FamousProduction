<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'client_id' => $this->client_id,
            'service_id'=> $this->service_id,
            'rating'    => $this->rating,
            'comment'   => $this->comment,
            'created_at'=> $this->created_at,
            'client'    => $this->whenLoaded('client', function () {
                return [
                    'id'    => $this->client->id,
                    'name'  => $this->client->name,
                    'email' => $this->client->email,
                ];
            }),
        ];
    }
}
