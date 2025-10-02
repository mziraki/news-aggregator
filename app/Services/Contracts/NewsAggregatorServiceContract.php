<?php

namespace App\Services\Contracts;

use App\Exceptions\NewsFetchException;

interface NewsAggregatorServiceContract
{
    public function getProviders(): array;

    /**
     * Fetch and store articles from all providers sequentially (for CLI/console use)
     */
    public function fetchAndStore(?string $query = null): array;

    /**
     * Fetch and store articles from a single provider.
     * This is used by jobs for async fetching.
     *
     * @throws NewsFetchException
     */
    public function fetchAndStoreProvider(NewsProviderServiceContract $provider, ?string $query = null): array;
}
