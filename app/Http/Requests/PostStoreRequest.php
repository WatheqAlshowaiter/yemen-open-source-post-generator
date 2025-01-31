<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'url' => ['required', 'string'],
            'username' => ['required', 'string'],
            'generated_content' => ['nullable', 'string'],
            'generted_title' => ['nullable', 'string'],
            'forked_url' => ['nullable', 'string'],
            'social_links' => ['nullable', 'json'],
            'other_links' => ['nullable', 'json'],
            'description' => ['nullable', 'string'],
        ];
    }
}
