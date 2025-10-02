<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Services\Contracts\CategoryServiceContract;
use Illuminate\Database\Eloquent\Collection;

class CategoryService implements CategoryServiceContract
{
    public function __construct(protected CategoryRepositoryContract $repository) {}

    public function getCategories(): Collection
    {
        return $this->repository->getCategories();
    }
}
