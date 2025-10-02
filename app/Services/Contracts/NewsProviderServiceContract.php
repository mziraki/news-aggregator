<?php

namespace App\Services\Contracts;

interface NewsProviderServiceContract
{
    /**
     * Fetch normalized articles. Return array of items with keys:
     * external_id, title, summary, body, url, image_url, published_at (Carbon string), author, categories (array), source_key, raw
     */
    public function fetch(?string $query = null): array;

    public function normalize(array $response): array;
}
