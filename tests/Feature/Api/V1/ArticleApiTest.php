<?php

use App\Models\Article;

beforeEach(function () {
    Article::factory()->create(['source_key' => 'guardian', 'title' => 'Technology News', 'author' => 'John']);
    Article::factory()->create(['source_key' => 'nytimes', 'title' => 'Sports News', 'author' => 'Jane']);
});

it('lists articles with filters', function () {
    $this
        ->getJson('/api/v1/articles?q=Technology')
        ->assertOk()
        ->assertJsonFragment(['title' => 'Technology News']);
});

it('filters articles by author', function () {
    $this
        ->getJson('/api/v1/articles?author=John')
        ->assertOk()
        ->assertJsonMissing(['author' => 'Jane']);
});
