<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
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
            'photo_id'           => ['required', 'exists:photos,id'],
            'announcement_type'  => ['required', 'in:info,warning,update,feature'],
            'announcement_status'=> ['required', 'in:draft,published,archived'],
            'body'               => ['required', 'string', 'max:1000'],
            'published_at'       => ['required', 'date'],
        ];
    }
}
