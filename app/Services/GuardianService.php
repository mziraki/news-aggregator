<?php

namespace App\Services;

use App\Exceptions\NewsFetchException;
use App\Services\Contracts\NewsProviderServiceContract;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GuardianService implements NewsProviderServiceContract
{
    public function fetch(?string $query = null): array
    {
        try {
            $q = $query ?: 'news';
            $response = Http::get('https://content.guardianapis.com/search', [
                'q' => $q,
                'api-key' => config('services.guardian.key'),
                'show-fields' => 'trailText,bodyText,thumbnail',
                'page-size' => config('services.guardian.page_size'),
            ]);

            if (! $response->successful()) {
                throw new Exception('API returned status '.$response->status());
            }

            return $this->normalize($response->json('response.results', []));
        } catch (Throwable $e) {
            Log::error('Guardian API fetch failed', ['error' => $e->getMessage()]);
            throw NewsFetchException::providerFailed('Guardian', $e->getMessage());
        }
    }

    public function normalize(array $response): array
    {
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
        }, $response);
    }
}
