<?php

namespace App\Providers;

use App\Services\News\GuardianService;
use App\Services\News\NewsAggregatorService;
use App\Services\News\NewsApiService;
use App\Services\News\NytService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NewsAggregatorService::class, function ($app) {
            return new NewsAggregatorService([
                'newsapi' => new NewsApiService,
                'nyt' => new NytService,
                'guardian' => new GuardianService,
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
    }
}
