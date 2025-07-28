<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_id'      => ['nullable', 'exists:posts,id'],
            'photo_id'     => ['nullable', 'exists:photos,id'],
            'comment_text' => ['required', 'string', 'max:1000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $hasPost  = $this->filled('post_id');
            $hasPhoto = $this->filled('photo_id');

            if (!($hasPost xor $hasPhoto)) {
                $validator->errors()->add('target', 'You must provide either a post_id or a photo_id, but not both.');
            }
        });
    }
}
