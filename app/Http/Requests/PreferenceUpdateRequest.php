<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreferenceUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'preferred_sources' => 'nullable|array',
            'preferred_sources.*' => 'string|in:'.config('sources.keys'),
            'preferred_categories' => 'nullable|array',
            'preferred_categories.*' => 'string|exists:categories,slug',
            'preferred_authors' => 'nullable|array',
            'preferred_authors.*' => 'string|max:255',
        ];
    }
}
