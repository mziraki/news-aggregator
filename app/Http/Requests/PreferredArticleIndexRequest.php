<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreferredArticleIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'nullable|integer|min:1',
            'perPage' => 'nullable|integer|between:20,50',
        ];
    }
}
