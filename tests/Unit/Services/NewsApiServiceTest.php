<?php

use App\Exceptions\NewsFetchException;
use App\Services\NewsApiService;
use Illuminate\Support\Facades\Http;

it('normalizes NewsAPI API response', function () {
    Http::fake([
        'newsapi.org/*' => Http::response([
            'articles' => [
                [
                    'url' => 'https://newsapi.org/article1',
                    'title' => 'NewsAPI Title',
                    'description' => 'Short description',
                    'content' => 'Full body content',
                    'urlToImage' => 'https://img.newsapi.org/1.jpg',
                    'publishedAt' => now()->toISOString(),
                    'author' => 'NewsAPI Author',
                ],
            ],
        ]),
    ]);

    $service = new NewsApiService;
    $articles = $service->fetch();

    expect($articles)->toHaveCount(1)
        ->and($articles[0]['title'])->toBe('NewsAPI Title')
        ->and($articles[0]['author'])->toBe('NewsAPI Author')
        ->and($articles[0]['source_key'])->toBe('newsapi');
});

it('throws exception when NewsAPI API fails', function () {
    Http::fake([
        'newsapi.org/*' => Http::response([], 500),
    ]);

    $service = new NewsApiService;
    $this->expectException(NewsFetchException::class);
    $service->fetch();
});
