<?php

use App\Services\News\NewsApiService;
use Illuminate\Support\Facades\Http;

it('normalizes NewsAPI.org response', function () {
    Http::fake([
        'newsapi.org/*' => Http::response([
            'articles' => [
                [
                    'url' => 'https://newsapi.org/article1',
                    'title' => 'NewsAPI Article',
                    'description' => 'Short description',
                    'content' => 'Full body content',
                    'urlToImage' => 'https://img.newsapi.org/1.jpg',
                    'publishedAt' => now()->toISOString(),
                    'author' => 'Alice',
                ],
            ],
        ], 200),
    ]);

    $service = new NewsApiService;
    $articles = $service->fetch('sports');

    expect($articles)->toHaveCount(1)
        ->and($articles[0]['author'])->toBe('Alice');
});
