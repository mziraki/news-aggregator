<?php

use App\Services\News\NytService;
use Illuminate\Support\Facades\Http;

it('normalizes NYTimes response', function () {
    Http::fake([
        'api.nytimes.com/*' => Http::response([
            'response' => [
                'docs' => [
                    [
                        '_id' => 'nyt-001',
                        'headline' => ['main' => 'NYT Headline'],
                        'abstract' => 'NYT abstract',
                        'lead_paragraph' => 'NYT full content',
                        'web_url' => 'https://nytimes.com/article',
                        'pub_date' => now()->toISOString(),
                        'byline' => ['original' => 'By Bob'],
                        'section_name' => 'World',
                    ],
                ],
            ],
        ], 200),
    ]);

    $service = new NytService;
    $articles = $service->fetch('world');

    expect($articles)->toHaveCount(1)
        ->and($articles[0]['title'])->toBe('NYT Headline')
        ->and($articles[0]['author'])->toBe('By Bob');
});
