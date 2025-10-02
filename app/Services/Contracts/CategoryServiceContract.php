<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CategoryServiceContract
{
    public function getCategories(): Collection;
}
