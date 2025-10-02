<?php

use App\Models\Category;

it('lists categories', function () {
    Category::factory()->create(['name' => 'Technology', 'slug' => 'technology']);

    $this->getJson('/api/v1/categories')
        ->assertOk()
        ->assertJsonFragment(['name' => 'Technology', 'slug' => 'technology']);
});
