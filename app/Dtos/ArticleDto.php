<?php

namespace App\Dtos;

class ArticleDto extends BaseDto
{
    public function __construct(
        public readonly ?string $external_id,
        public readonly ?string $title,
        public readonly ?string $summary,
        public readonly ?string $body,
        public readonly ?string $url,
        public readonly ?string $image_url,
        public readonly ?string $published_at,
        public readonly ?string $author,
        public readonly array $categories,
        public readonly string $source_key,
        public readonly array $raw = [],
    ) {}
}
