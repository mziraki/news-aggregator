<?php

namespace App\Services\News;

use App\Services\News\Contracts\NewsProviderInterface;
use Illuminate\Support\Facades\Http;

class NewsApiService implements NewsProviderInterface
{
    public function fetch(?string $query = null): array
    {
        $q = $query ?: 'news';
        $response = Http::get('https://newsapi.org/v2/everything', [
            'q' => $q,
            'apiKey' => config('services.newsapi.key'),
            'language' => 'en',
            'pageSize' => config('services.newsapi.page_size'),
        ]);

        if (! $response->successful()) {
            return [];
        }

        $items = $response->json('articles', []);

        return array_map(function ($item) {
            return [
                'external_id' => $item['url'] ?? null,
                'title' => $item['title'] ?? null,
                'summary' => $item['description'] ?? null,
                'body' => null,
                'url' => $item['url'] ?? null,
                'image_url' => $item['urlToImage'] ?? null,
                'published_at' => $item['publishedAt'] ?? null,
                'author' => $item['author'] ?? null,
                'categories' => [],
                'source_key' => 'newsapi',
                'raw' => $item,
            ];
        }, $items);
    }
}
