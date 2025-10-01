<?php

use App\Services\News\GuardianService;
use Illuminate\Support\Facades\Http;

it('normalizes Guardian API response', function () {
    Http::fake([
        'content.guardianapis.com/*' => Http::response([
            'response' => [
                'results' => [
                    [
                        'id' => 'guardian-123',
                        'webTitle' => 'Guardian Article',
                        'webUrl' => 'https://theguardian.com/test',
                        'webPublicationDate' => now()->toISOString(),
                        'sectionName' => 'Technology',
                        'fields' => [
                            'trailText' => 'Summary text',
                            'bodyText' => 'Full body text',
                            'thumbnail' => 'https://img.guardian.com/1.jpg',
                        ],
                    ],
                ],
            ],
        ], 200),
    ]);

    $service = new GuardianService;
    $articles = $service->fetch('tech');

    expect($articles)->toHaveCount(1)
        ->and($articles[0]['title'])->toBe('Guardian Article')
        ->and($articles[0]['source_key'])->toBe('guardian');
});
