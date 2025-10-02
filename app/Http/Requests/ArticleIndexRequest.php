<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => 'nullable|string|max:255',
            'source' => 'nullable|string|in:'.config('sources.keys'),
            'category' => 'nullable|string|exists:categories,slug',
            'from' => 'nullable|date',
            'to' => 'nullable|date|after_or_equal:from',
            'author' => 'nullable|string|max:255',
            'page' => 'nullable|integer|min:1',
            'perPage' => 'nullable|integer|between:'.config('pagination.per_page').','.config('pagination.max_per_page'),
        ];
    }

    public function messages(): array
    {
        return [
            'source.exists' => 'The selected source does not exist.',
            'category.exists' => 'The selected category does not exist.',
            'to.after_or_equal' => 'The "to" date must be after or equal to the "from" date.',
        ];
    }
}
