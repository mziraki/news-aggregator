<?php

use App\Exceptions\NewsFetchException;
use App\Services\NytimesService;
use Illuminate\Support\Facades\Http;

it('normalizes NYTimes response', function () {
    Http::fake([
        'api.nytimes.com/*' => Http::response([
            'response' => [
                'docs' => [
                    [
                        '_id' => 'nyt-001',
                        'headline' => ['main' => 'NYTimes Headline'],
                        'abstract' => 'NYTimes abstract',
                        'lead_paragraph' => 'NYTimes full content',
                        'web_url' => 'https://nytimes.com/article',
                        'pub_date' => now()->toISOString(),
                        'byline' => ['original' => 'John'],
                        'section_name' => 'World',
                    ],
                ],
            ],
        ]),
    ]);

    $service = new NytimesService;
    $articles = $service->fetch();

    expect($articles)->toHaveCount(config('services.nytimes.page_limit'))
        ->and($articles[0]['title'])->toBe('NYTimes Headline')
        ->and($articles[0]['author'])->toBe('John')
        ->and($articles[0]['source_key'])->toBe('nytimes');
});

it('throws exception when NewsAPI API fails', function () {
    Http::fake([
        'api.nytimes.com/*' => Http::response([], 500),
    ]);

    $service = new NytimesService;
    $this->expectException(NewsFetchException::class);
    $service->fetch();
});
