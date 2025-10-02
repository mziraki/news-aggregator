<?php

use App\Http\Resources\CategoryResource;
use App\Models\Category;

it('transforms a category into the expected array', function () {
    $attrs = [
        'name' => 'Science',
        'slug' => 'science',
    ];

    $category = Category::factory()->create($attrs);

    $resource = (new CategoryResource($category))->resolve();

    expect($resource)->toMatchArray($attrs);
});
