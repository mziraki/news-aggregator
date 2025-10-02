<?php

use App\Exceptions\NewsFetchException;
use App\Jobs\FetchNewsProviderJob;
use App\Services\Contracts\NewsAggregatorServiceContract;
use App\Services\Contracts\NewsProviderServiceContract;
use Illuminate\Support\Facades\Log;

it('calls fetchAndStoreProvider on the aggregator', function () {
    $provider = Mockery::mock(NewsProviderServiceContract::class);

    $aggregator = Mockery::mock(NewsAggregatorServiceContract::class);
    $aggregator
        ->shouldReceive('fetchAndStoreProvider')
        ->once()
        ->with($provider, 'laravel')
        ->andReturn([]);

    $job = new FetchNewsProviderJob($provider, 'laravel');
    $job->handle($aggregator);
});

it('logs error when NewsFetchException is thrown', function () {
    Log::spy();

    $provider = Mockery::mock(NewsProviderServiceContract::class);

    $aggregator = Mockery::mock(NewsAggregatorServiceContract::class);
    $aggregator
        ->shouldReceive('fetchAndStoreProvider')
        ->once()
        ->with($provider, null)
        ->andThrow(NewsFetchException::providerFailed('Guardian', 'API down'));

    $job = new FetchNewsProviderJob($provider);
    $job->handle($aggregator);

    Log::shouldHaveReceived('error')
        ->once()
        ->with(Mockery::on(fn ($message) => str_contains($message, 'Guardian')));
});
