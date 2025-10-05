<?php

namespace App\Services;

use App\Dtos\ArticleDto;
use App\Exceptions\NewsFetchException;
use App\Services\Contracts\NewsProviderServiceContract;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class NewsApiService implements NewsProviderServiceContract
{
    public function fetch(?string $query = null): array
    {
        try {
            $q = $query ?: 'news';
            $response = Http::get(config('services.newsapi.url'), [
                'q' => $q,
                'apiKey' => config('services.newsapi.key'),
                'language' => 'en',
                'pageSize' => config('services.newsapi.page_size'),
            ]);

            if (! $response->successful()) {
                throw new Exception('API returned status '.$response->status());
            }

            return array_map(fn ($item) => new ArticleDTO(
                external_id: $item['url'] ?? null,
                title: $item['title'] ?? null,
                summary: $item['description'] ?? null,
                body: null,
                url: $item['url'] ?? null,
                image_url: $item['urlToImage'] ?? null,
                published_at: $item['publishedAt'] ?? null,
                author: $item['author'] ?? null,
                categories: [],
                source_key: 'newsapi',
                raw: $item,
            ), $response->json('articles', []));
        } catch (Throwable $e) {
            Log::error('NewsAPI API fetch failed', ['error' => $e->getMessage()]);
            throw NewsFetchException::providerFailed('NewsAPI', $e->getMessage());
        }
    }
}
