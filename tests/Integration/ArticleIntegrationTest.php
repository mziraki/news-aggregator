<?php

use App\Models\Article;
use App\Models\Source;

beforeEach(function () {
    Article::factory()->count(2)->create([
        'source_id' => Source::factory()->create(['key' => 'guardian', 'name' => 'Guardian']),
        'title' => 'Integration Article',
        'author' => 'Alice',
    ]);
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
