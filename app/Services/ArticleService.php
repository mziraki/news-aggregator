<?php

namespace App\Services;

use App\Repositories\Contracts\ArticleRepositoryContract;
use App\Services\Contracts\ArticleServiceContract;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService implements ArticleServiceContract
{
    public function __construct(protected ArticleRepositoryContract $repository) {}

    public function getArticles(array $filters = []): LengthAwarePaginator
    {
        $filters['perPage'] = $filters['perPage'] ?? config('pagination.per_page');

        return $this->repository->getArticles($filters)->through(function ($article) {
            $article->summary = strip_tags($article->summary);

            return $article;
        });
    }

    public function getPreferredArticles(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return $this->repository->getPreferredArticles($userId, $perPage);
    }
}
