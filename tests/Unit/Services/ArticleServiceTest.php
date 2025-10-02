<?php

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryContract;
use App\Services\ArticleService;
use Illuminate\Pagination\LengthAwarePaginator;

beforeEach(function () {
    $this->repository = Mockery::mock(ArticleRepositoryContract::class);
    $this->service = new ArticleService($this->repository);
});

it('gets articles with summary sanitized', function () {
    $article = new Article([
        'title' => 'Demo',
        'summary' => '<p>Hello <strong>World</strong></p>',
    ]);

    $paginator = new LengthAwarePaginator(collect([$article]), 1, config('pagination.per_page'), 1);

    $this->repository
        ->shouldReceive('getArticles')
        ->once()
        ->withArgs(fn ($filters) => isset($filters['perPage']))
        ->andReturn($paginator);

    $result = $this->service->getArticles();

    expect($result->first()->summary)->toBe('Hello World');
});

it('gets preferred articles for a user', function () {
    $userId = 42;

    $article = new Article([
        'title' => 'Preferred Article',
        'summary' => 'Clean',
    ]);

    $perPage = config('pagination.per_page');
    $paginator = new LengthAwarePaginator(collect([$article]), 1, $perPage, 1);

    $this->repository
        ->shouldReceive('getPreferredArticles')
        ->once()
        ->with($userId, $perPage)
        ->andReturn($paginator);

    $result = $this->service->getPreferredArticles($userId);

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($result->first()->title)->toBe('Preferred Article');
});
