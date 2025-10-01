<?php

use App\Services\News\Contracts\NewsProviderInterface;
use App\Services\News\NewsAggregatorService;

it('aggregates articles from multiple providers', function () {
    $provider1 = Mockery::mock(NewsProviderInterface::class);
    $provider1->shouldReceive('fetch')->andReturn([
        ['title' => 'Article 1', 'url' => fake()->url(), 'source_key' => 'guardian'],
    ]);

    $provider2 = Mockery::mock(NewsProviderInterface::class);
    $provider2->shouldReceive('fetch')->andReturn([
        ['title' => 'Article 2', 'url' => fake()->url(), 'source_key' => 'nyt'],
    ]);

    $service = new NewsAggregatorService([
        'guardian' => $provider1,
        'nyt' => $provider2,
    ]);
    $articles = $service->fetchAndStore();

    expect($articles)->toHaveCount(2);
});
