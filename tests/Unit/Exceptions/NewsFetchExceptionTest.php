<?php

use App\Exceptions\NewsFetchException;

it('creates an exception via providerFailed named constructor', function () {
    $exception = NewsFetchException::providerFailed('Guardian', 'API timeout');

    expect($exception)->toBeInstanceOf(NewsFetchException::class)
        ->and($exception->getMessage())->toContain('Guardian')
        ->and($exception->getMessage())->toContain('API timeout');
});

it('can be thrown and caught', function () {
    try {
        throw NewsFetchException::providerFailed('NYT', 'Invalid key');
    } catch (NewsFetchException $e) {
        expect($e->getMessage())->toBe('Fetching news from NYT failed: Invalid key');
    }
});
