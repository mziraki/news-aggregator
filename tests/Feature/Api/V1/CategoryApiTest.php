<?php

use App\Models\Category;

it('lists categories', function () {
    Category::factory()->create(['name' => 'Technology', 'slug' => 'technology']);

    $this
        ->getJson(route('api.v1.categories.index', absolute: false))
        ->assertOk()
        ->assertJsonFragment(['name' => 'Technology', 'slug' => 'technology']);
});
