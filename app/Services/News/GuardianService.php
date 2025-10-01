<?php

namespace App\Services\News;

use App\Services\News\Contracts\NewsProviderInterface;
use Illuminate\Support\Facades\Http;

class GuardianService implements NewsProviderInterface
{
    public function fetch(?string $query = null): array
    {
        $q = $query ?: 'news';
        $response = Http::timeout(10)->get('https://content.guardianapis.com/search', [
            'q' => $q,
            'api-key' => config('services.guardian.key'),
            'show-fields' => 'trailText,bodyText,thumbnail',
            'page-size' => 50,
        ]);

        if (! $response->successful()) {
            return [];
        }

        $items = $response->json('response.results', []);

        return array_map(function ($item) {
            return [
                'external_id' => $item['id'] ?? null,
                'title' => $item['webTitle'] ?? null,
                'summary' => $item['fields']['trailText'] ?? null,
                'body' => $item['fields']['bodyText'] ?? null,
                'url' => $item['webUrl'] ?? null,
                'image_url' => $item['fields']['thumbnail'] ?? null,
                'published_at' => $item['webPublicationDate'] ?? null,
                'author' => $item['fields']['byline'] ?? null,
                'categories' => [$item['sectionName'] ?? null],
                'source_key' => 'guardian',
                'raw' => $item,
            ];
        }, $items);
    }
}
