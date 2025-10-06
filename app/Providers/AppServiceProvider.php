<?php

namespace App\Providers;

use App\Repositories\Contracts\ArticleRepositoryContract;
use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Services\ArticleService;
use App\Services\CategoryService;
use App\Services\Contracts\ArticleServiceContract;
use App\Services\Contracts\CategoryServiceContract;
use App\Services\Contracts\NewsAggregatorServiceContract;
use App\Services\Contracts\UserServiceContract;
use App\Services\GuardianService;
use App\Services\NewsAggregatorService;
use App\Services\NewsApiService;
use App\Services\NytimesService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NewsAggregatorService::class, function ($app) {
            $service = new NewsAggregatorService(
                resolve(ArticleRepositoryContract::class),
                resolve(CategoryRepositoryContract::class),
            );
            $service->setProviders([
                new GuardianService,
                new NewsApiService,
                new NytimesService,
            ]);

            return $service;
        });

        $this->app->bind(ArticleServiceContract::class, ArticleService::class);
        $this->app->bind(CategoryServiceContract::class, CategoryService::class);
        $this->app->bind(NewsAggregatorServiceContract::class, NewsAggregatorService::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        if (! $this->app->runningUnitTests()) {
            Http::swap(Http::withOptions([
                'timeout' => config('http.timeout'),
                'connect_timeout' => config('http.connect_timeout'),
            ]));
        }
    }
}
