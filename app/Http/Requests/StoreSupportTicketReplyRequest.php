<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportTicketReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message'     => ['required', 'string'],
            'is_internal' => ['nullable', 'boolean'],
            'attachments.*' => ['nullable', 'file', 'max:2048'],
        ];
    }
}
