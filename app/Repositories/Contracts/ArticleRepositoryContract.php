<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryContract
{
    public function getArticles(array $filters = []): LengthAwarePaginator;

    public function getPreferredArticles(int $userId, int $perPage): LengthAwarePaginator;
}
