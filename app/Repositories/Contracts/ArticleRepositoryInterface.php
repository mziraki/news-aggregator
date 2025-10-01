<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ArticleRepositoryInterface
{
    public function search(array $filters = []): LengthAwarePaginator;

    public function getCategories(): Collection;

    public function getPreferredForUser(int $userId, int $perPage): LengthAwarePaginator;
}
