<?php

namespace App\Console\Commands;

use App\Services\News\NewsAggregatorService;
use Illuminate\Console\Command;

class FetchNewsCommand extends Command
{
    protected $signature = 'news:fetch {query?}';

    protected $description = 'Fetch news articles from all providers';

    public function __construct(protected NewsAggregatorService $aggregator)
    {
        parent::__construct();
    }

    public function handle()
    {
        $query = $this->argument('query');
        $stored = $this->aggregator->fetchAndStore($query);

        $this->info(count($stored).' article(s) has been created/modified.');

        return 0;
    }
}
