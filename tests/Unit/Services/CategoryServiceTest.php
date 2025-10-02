<?php

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;

it('returns categories from repository', function () {
    $repository = Mockery::mock(CategoryRepositoryContract::class);
    $service = new CategoryService($repository);

    $categories = new Collection([
        new Category(['name' => 'Technology', 'slug' => 'technology']),
        new Category(['name' => 'Sports', 'slug' => 'sports']),
    ]);

    $repository
        ->shouldReceive('getCategories')
        ->once()
        ->andReturn($categories);

    $result = $service->getCategories();

    expect($result)->toBeInstanceOf(Collection::class)
        ->and($result)->toHaveCount(2)
        ->and($result->first()->name)->toBe('Technology');
});
