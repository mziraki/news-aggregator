<?php

namespace App\Jobs;

use App\Exceptions\NewsFetchException;
use App\Services\Contracts\NewsAggregatorServiceContract;
use App\Services\Contracts\NewsProviderServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchNewsProviderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected NewsProviderServiceContract $provider,
        protected ?string $query = null,
    ) {}

    public function handle(NewsAggregatorServiceContract $aggregator)
    {
        try {
            $aggregator->fetchAndStoreProvider($this->provider, $this->query);
        } catch (NewsFetchException $e) {
            Log::error('Job failed: '.$e->getMessage());
        }
    }
}
