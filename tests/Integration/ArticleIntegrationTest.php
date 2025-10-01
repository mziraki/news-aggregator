<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\Source;

beforeEach(function () {
    Category::factory()->create(['name' => 'Technology', 'slug' => 'technology']);

    Article::factory()->count(2)->create([
        'source_id' => Source::factory()->create(['key' => 'guardian', 'name' => 'Guardian']),
        'title' => 'Integration Article',
        'author' => 'Alice',
    ]);
});

it('returns categories from DB through API', function () {
    $this->getJson('/api/v1/categories')
        ->assertOk()
        ->assertJsonFragment(['name' => 'Technology', 'slug' => 'technology']);
});

it('returns articles from DB through API', function () {
    $this->getJson('/api/v1/articles')
        ->assertOk()
        ->assertJsonFragment(['title' => 'Integration Article']);
});

it('filters articles by author', function () {
    $this->getJson('/api/v1/articles?author=Alice')
        ->assertOk()
        ->assertJsonFragment(['author' => 'Alice']);
});
