<?php

use App\Exceptions\NewsFetchException;
use App\Services\GuardianService;
use Illuminate\Support\Facades\Http;

it('normalizes Guardian API response', function () {
    Http::fake([
        'content.guardianapis.com/*' => Http::response([
            'response' => [
                'results' => [[
                    'id' => 'guardian/technology/1',
                    'webTitle' => 'Guardian Title',
                    'webUrl' => 'https://guardian.com/article',
                    'webPublicationDate' => now()->toISOString(),
                    'sectionName' => 'Technology',
                    'fields' => [
                        'trailText' => 'Summary text',
                        'bodyText' => 'Full text',
                        'thumbnail' => 'https://img.jpg',
                        'byline' => 'Guardian Author',
                    ],
                ]],
            ],
        ]),
    ]);

    $service = new GuardianService;
    $articles = $service->fetch();

    expect($articles)->toHaveCount(1)
        ->and($articles[0]->title)->toBe('Guardian Title')
        ->and($articles[0]->author)->toBe('Guardian Author')
        ->and($articles[0]->source_key)->toBe('guardian');
});

it('throws exception when Guardian API fails', function () {
    Http::fake([
        'https://content.guardianapis.com/*' => Http::response([], 500),
    ]);

    $service = new GuardianService;
    $this->expectException(NewsFetchException::class);
    $service->fetch();
});
