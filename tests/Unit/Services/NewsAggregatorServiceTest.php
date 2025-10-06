<?php

use App\Exceptions\NewsFetchException;
use App\Repositories\Contracts\ArticleRepositoryContract;
use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Services\Contracts\NewsProviderServiceContract;
use App\Services\NewsAggregatorService;

beforeEach(function () {
    $this->service = new NewsAggregatorService(
        Mockery::mock(ArticleRepositoryContract::class),
        Mockery::mock(CategoryRepositoryContract::class),
    );
});

it('fetches and stores articles from multiple providers', function () {
    $provider1 = Mockery::mock(NewsProviderServiceContract::class);
    $provider1->shouldReceive('fetch')->andReturn([
        ['external_id' => '1', 'source_key' => 'guardian', 'title' => 'From Provider1', 'url' => fake()->url()],
    ]);

    $provider2 = Mockery::mock(NewsProviderServiceContract::class);
    $provider2->shouldReceive('fetch')->andReturn([
        ['external_id' => '2', 'source_key' => 'nytimes', 'title' => 'From Provider2', 'url' => fake()->url()],
    ]);

    $this->service->setProviders([$provider1, $provider2]);
    $articles = $this->service->fetchAndStore();

    expect($articles)->toHaveCount(2)
        ->and($articles[0]['title'])->toBe('From Provider1')
        ->and($articles[1]['title'])->toBe('From Provider2');
});

it('throws NewsFetchException if provider fails', function () {
    $provider = Mockery::mock(NewsProviderServiceContract::class);
    $provider->shouldReceive('fetch')->andThrow(new Exception('API down'));

    $this->service->setProviders([$provider]);

    $this->expectException(NewsFetchException::class);
    $this->service->fetchAndStore();
});
