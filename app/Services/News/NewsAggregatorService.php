<?php

namespace App\Services\News;

use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Carbon\Carbon;
use Throwable;

class NewsAggregatorService
{
    public function __construct(protected array $providers) {}

    public function fetchAndStore(?string $query = null): array
    {
        $stored = [];

        foreach ($this->providers as $key => $provider) {
            try {
                $items = $provider->fetch($query);

                $source = Source::firstOrCreate(['key' => $key], ['name' => ucfirst($key), 'enabled' => true]);

                foreach ($items as $item) {
                    $externalId = $item['external_id'] ?? null;
                    $articleQuery = Article::where('source_id', $source->id)
                        ->when($externalId, fn ($q) => $q->where('external_id', $externalId));

                    if (! $externalId && ! empty($item['url'])) {
                        $articleQuery = Article::where('url', $item['url']);
                    }

                    $article = $articleQuery->first();

                    $data = [
                        'source_id' => $source->id,
                        'external_id' => $externalId,
                        'title' => $item['title'] ?? 'No title',
                        'summary' => $item['summary'] ?? null,
                        'body' => $item['body'] ?? null,
                        'url' => $item['url'] ?? null,
                        'image_url' => $item['image_url'] ?? null,
                        'published_at' => isset($item['published_at']) ? Carbon::parse($item['published_at']) : null,
                        'author' => $item['author'] ?? null,
                        'language' => $item['language'] ?? null,
                        'raw_json' => $item['raw'] ?? null,
                    ];

                    if ($article) {
                        $article->update($data);
                    } else {
                        $article = Article::create($data);
                    }

                    if (! empty($item['categories'])) {
                        $catIds = [];
                        foreach ($item['categories'] as $catName) {
                            if (! $catName) {
                                continue;
                            }
                            $cat = Category::firstOrCreate(['slug' => \Str::slug($catName)], ['name' => $catName]);
                            $catIds[] = $cat->id;
                        }
                        if (! empty($catIds)) {
                            $article->categories()->syncWithoutDetaching($catIds);
                        }
                    }

                    if ($article->wasRecentlyCreated || $article->wasChanged()) {
                        $stored[] = $article->id;
                    }
                }
            } catch (Throwable $e) {
                report($e); // Don’t break if one provider fails
            }
        }

        return $stored;
    }
}
