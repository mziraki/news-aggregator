<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository implements CategoryRepositoryContract
{
    protected function model(): string
    {
        return Category::class;
    }

    public function getCategories(): Collection
    {
        return $this->query()->get(['name', 'slug']);
    }
}
