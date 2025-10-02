<?php

namespace App\Console\Commands;

use App\Jobs\FetchNewsProviderJob;
use App\Services\Contracts\NewsAggregatorServiceContract;
use Illuminate\Console\Command;

class FetchNewsCommand extends Command
{
    protected $signature = 'news:fetch {query?}';

    protected $description = 'Fetch news articles from all providers asynchronously';

    public function __construct(protected NewsAggregatorServiceContract $aggregator)
    {
        parent::__construct();
    }

    public function handle()
    {
        $query = $this->argument('query');

        foreach ($this->aggregator->getProviders() as $provider) {
            FetchNewsProviderJob::dispatch($provider, $query);
        }

        $this->info('News fetch jobs dispatched!');

        return 0;
    }
}
