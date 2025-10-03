<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements BaseRepositoryContract
{
    protected string $model;

    abstract protected function model(): string;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function query(): Builder
    {
        return (new $this->model)->getModel()->query();
    }
}
