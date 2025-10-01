<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function search(array $filters = []): LengthAwarePaginator;

    public function getPreferredForUser(int $userId, int $perPage): LengthAwarePaginator;
}
