<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
   public function rules(): array
    {
        return [
            'booking_id'           => ['required', 'exists:bookings,id'],
            'client_id'            => ['required', 'exists:users,id'],
            'amount'               => ['required', 'numeric', 'min:0'],
            'payment_method'       => ['required', 'string', 'in:card,cash,bank_transfer,paypal'],
            'status'               => ['required', 'string', 'in:pending,completed,failed,cancelled'],
            'transaction_reference'=> ['required', 'string', 'max:255'],
        ];
    }
}
