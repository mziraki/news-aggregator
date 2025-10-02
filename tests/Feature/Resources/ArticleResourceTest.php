<?php

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;

it('transforms an article into the expected array', function () {
    $category = Category::factory()->create([
        'name' => 'Technology',
        'slug' => 'technology',
    ]);

    $article = Article::factory()
        ->hasAttached($category)
        ->create([
            'source_key' => 'guardian',
            'title' => 'Sample Article',
            'summary' => 'Summary text',
            'body' => 'Body text',
            'url' => 'https://example.com/article',
            'image_url' => 'https://example.com/image.jpg',
            'published_at' => now(),
            'author' => 'John',
        ]);

    $resource = (new ArticleResource($article))->resolve();

    expect($resource)
        ->toMatchArray([
            'id' => $article->id,
            'source_key' => 'guardian',
            'title' => 'Sample Article',
            'summary' => 'Summary text',
            'body' => 'Body text',
            'url' => 'https://example.com/article',
            'image_url' => 'https://example.com/image.jpg',
            'author' => 'John',
        ])
        ->and($resource['categories'])->toHaveCount(1)
        ->and($resource['categories'][0])->toMatchArray([
            'id' => $category->id,
            'name' => 'Technology',
            'slug' => 'technology',
        ]);
});
