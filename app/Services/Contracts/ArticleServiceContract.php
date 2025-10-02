<?php

namespace App\Services\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleServiceContract
{
    public function getArticles(array $filters = []): LengthAwarePaginator;

    public function getPreferredArticles(int $userId, int $perPage): LengthAwarePaginator;
}
