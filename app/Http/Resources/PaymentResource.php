<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'booking_id'            => $this->booking_id,
            'client_id'             => $this->client_id,
            'amount'                => $this->amount,
            'payment_method'        => $this->payment_method,
            'status'                => $this->status,
            'transaction_reference' => $this->transaction_reference,
            'created_at'            => $this->created_at,
        ];
    }
}
