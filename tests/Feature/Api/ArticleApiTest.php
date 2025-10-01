<?php

use App\Models\User;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user, ['*']);

    $this->repo = Mockery::mock(ArticleRepositoryInterface::class);
    $this->app->instance(ArticleRepositoryInterface::class, $this->repo);
});

it('uses repository search in index endpoint', function () {
    $paginator = new LengthAwarePaginator([], 0, 20, 1);

    $this->repo->shouldReceive('search')
        ->once()
        ->andReturn($paginator);

    $this->getJson('/api/v1/articles?q=test')->assertOk();
});

it('uses repository getPreferredForUser in preferred endpoint', function () {
    $paginator = new LengthAwarePaginator([], 0, 20, 1);

    $this->repo->shouldReceive('getPreferredForUser')
        ->with($this->user->id, 20)
        ->once()
        ->andReturn($paginator);

    $this->getJson('/api/v1/articles/preferred')->assertOk();
});
