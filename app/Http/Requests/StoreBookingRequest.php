<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
                'client_id'       => ['required', 'exists:users,id'],
                'photographer_id' => ['required', 'exists:users,id', 'different:client_id'],
                'service_id'      => ['required', 'exists:services,id'],
                'scheduled_date'  => ['required', 'date', 'after_or_equal:today'],
                'status'          => ['required', 'string', 'in:pending,confirmed,completed,cancelled'],
                'comment'         => ['nullable', 'string', 'max:1000'],
            ];
        }
}
