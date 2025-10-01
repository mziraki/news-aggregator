<?php

namespace App\Services\News;

use App\Services\News\Contracts\NewsProviderInterface;
use Illuminate\Support\Facades\Http;

class NytService implements NewsProviderInterface
{
    public function fetch(?string $query = null): array
    {
        $q = $query ?: 'news';
        $response = Http::timeout(10)->get('https://api.nytimes.com/svc/search/v2/articlesearch.json', [
            'q' => $q,
            'api-key' => config('services.nytimes.key'),
            'page' => 0,
        ]);

        if (! $response->successful()) {
            return [];
        }

        $items = $response->json('response.docs', []);

        return array_map(function ($item) {
            return [
                'external_id' => $item['_id'] ?? null,
                'title' => $item['headline']['main'] ?? null,
                'summary' => $item['abstract'] ?? null,
                'body' => null,
                'url' => $item['web_url'] ?? null,
                'image_url' => null,
                'published_at' => $item['pub_date'] ?? null,
                'author' => $item['byline']['original'] ?? null,
                'categories' => array_filter([$item['section_name'] ?? null, $item['subsection_name'] ?? null]),
                'source_key' => 'nyt',
                'raw' => $item,
            ];
        }, $items);
    }
}
