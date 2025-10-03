<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryContract
{
    public function query(): Builder;
}
