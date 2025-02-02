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
            'forked_url' => ['required', 'url'],
            'original_url' => ['required', 'url'],
            'repo_description' => ['required', 'string'],
            'author_name' => ['required', 'string'],
            'github_user_profile' => ['nullable', 'string', 'url'],
            'linkedin_profile' => ['nullable', 'string', 'url'],
            'facebook_profile' => ['nullable', 'string', 'url'],
            'twitter_profile' => ['nullable', 'string', 'url'],
            'author_website' => ['nullable', 'string', 'url'],
            'additional_links' => ['nullable', 'array'],
            'additional_links.*' => ['nullable', 'string', 'url'],
        ];
    }
}
