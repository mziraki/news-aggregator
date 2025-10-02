<?php

use App\Models\Category;
use App\Repositories\CategoryRepository;

it('returns all categories with name and slug only', function () {
    Category::factory()->create(['name' => 'Technology', 'slug' => 'technology']);
    Category::factory()->create(['name' => 'Sports', 'slug' => 'sports']);

    $result = (new CategoryRepository)->getCategories();

    expect($result)->toHaveCount(2);

    $first = $result->first()->toArray();
    expect($first)->toHaveKeys(['name', 'slug'])
        ->and($first)->not->toHaveKey('id');
});
