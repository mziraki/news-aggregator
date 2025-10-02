<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PreferenceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'preferred_sources' => $this->preferred_sources,
            'preferred_categories' => $this->preferred_categories,
            'preferred_authors' => $this->preferred_authors,
        ];
    }
}
