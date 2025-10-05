<?php

namespace App\Services;

use App\Exceptions\NewsFetchException;
use App\Models\Article;
use App\Models\Category;
use App\Services\Contracts\NewsAggregatorServiceContract;
use App\Services\Contracts\NewsProviderServiceContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class NewsAggregatorService implements NewsAggregatorServiceContract
{
    public function __construct(protected array $providers = []) {}

    public function getProviders(): array
    {
        return $this->providers;
    }

    public function fetchAndStore(?string $query = null): array
    {
        $allArticles = [];

        foreach ($this->providers as $provider) {
            $articles = $this->fetchAndStoreProvider($provider, $query);
            $allArticles = array_merge($allArticles, $articles);
        }

        return $allArticles;
    }

    public function fetchAndStoreProvider(NewsProviderServiceContract $provider, ?string $query = null): array
    {
        try {
            $articles = $provider->fetch($query);

            foreach ($articles as $article) {
                if (empty($article->external_id) || empty($article->source_key)) {
                    continue;
                }

                DB::beginTransaction();

                $art = Article::updateOrCreate(
                    [
                        'external_id' => $article->external_id,
                        'source_key' => $article->source_key,
                    ],
                    [
                        'title' => $article->title ?? 'No title',
                        'summary' => $article->summary ?? null,
                        'body' => $article->body ?? null,
                        'url' => $article->url ?? null,
                        'image_url' => $article->image_url ?? null,
                        'author' => $article->author ?? null,
                        'published_at' => isset($article->published_at) ? Carbon::parse($article->published_at) : null,
                        'language' => $article->language ?? null,
                        'raw_json' => $article->raw ?? null,
                    ]
                );

                if (! empty($article->categories)) {
                    $catIds = [];
                    foreach ($article->categories as $catName) {
                        if (! $catName) {
                            continue;
                        }
                        $cat = Category::firstOrCreate(['slug' => Str::slug($catName)], ['name' => $catName]);
                        $catIds[] = $cat->getKey();
                    }
                    if (! empty($catIds)) {
                        $art->categories()->syncWithoutDetaching($catIds);
                    }
                }

                Db::commit();
            }

            return $articles;
        } catch (Throwable $e) {
            $providerName = get_class($provider);
            Log::error("News fetch failed for provider {$providerName}", [
                'error' => $e->getMessage(),
            ]);

            throw NewsFetchException::providerFailed($providerName, $e->getMessage());
        }
    }
}
