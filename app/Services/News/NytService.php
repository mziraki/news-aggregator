<?php

namespace App\Services\News;

use App\Services\News\Contracts\NewsProviderInterface;
use Illuminate\Support\Facades\Http;

class NytService implements NewsProviderInterface
{
    public function fetch(?string $query = null): array
    {
        $pages = range(0, config('services.nytimes.page_limit') - 1);
        $q = $query ?: 'news';
        $responses = Http::pool(fn ($pool) => collect($pages)->map(fn ($page) => $pool->get('https://api.nytimes.com/svc/search/v2/articlesearch.json', [
            'q' => $q,
            'api-key' => config('services.nytimes.key'),
            'page' => $page,
        ])
        )->toArray());

        $items = [];
        foreach ($responses as $i => $resp) {
            if ($resp->successful()) {
                $items = array_merge($items, $resp->json('response.docs', []));
            }
        }

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
