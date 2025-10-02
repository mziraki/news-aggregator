<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Repositories\ArticleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

beforeEach(function () {
    $this->repository = new ArticleRepository;
});

it('returns paginated articles without filters', function () {
    Article::factory()->count(3)->create();

    $result = $this->repository->getArticles();

    expect($result)->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($result->total())->toBe(3);
});

it('filters articles by query in title, summary, or body', function () {
    Article::factory()->create(['title' => 'Laravel Tips']);
    Article::factory()->create(['summary' => 'Great PHP tricks']);
    Article::factory()->create(['body' => 'Hidden Laravel features']);
    Article::factory()->create(['title' => 'Vue Guide']);

    $result = $this->repository->getArticles(['q' => 'Laravel']);

    expect($result->total())->toBe(2);
});

it('filters articles by source', function () {
    Article::factory()->create(['title' => 'From Guardian', 'source_key' => 'guardian']);
    Article::factory()->create(['title' => 'From NYT', 'source_key' => 'nytimes']);

    $result = $this->repository->getArticles(['source' => 'nytimes']);

    expect($result->total())->toBe(1)
        ->and($result->first()->source_key)->toBe('nytimes');
});

it('filters articles by category', function () {
    $technology = Category::factory()->create(['slug' => 'technology']);
    $sports = Category::factory()->create(['slug' => 'sports']);

    $article1 = Article::factory()->create();
    $article1->categories()->attach($technology);

    $article2 = Article::factory()->create();
    $article2->categories()->attach($sports);

    $result = $this->repository->getArticles(['category' => 'technology']);

    expect($result->total())->toBe(1)
        ->and($result->first()->categories->first()->slug)->toBe('technology');
});

it('filters articles by author', function () {
    Article::factory()->create(['author' => 'Jane']);
    Article::factory()->create(['author' => 'John']);

    $result = $this->repository->getArticles(['author' => 'Jane']);

    expect($result->total())->toBe(1)
        ->and($result->first()->author)->toBe('Jane');
});

it('returns articles matching user preferences', function () {
    $user = User::factory()->create([
        'preferred_sources' => ['guardian'],
        'preferred_categories' => ['technology'],
        'preferred_authors' => ['Jane'],
    ]);

    $technology = Category::factory()->create(['slug' => 'technology']);
    $sports = Category::factory()->create(['slug' => 'sports']);

    $matching = Article::factory()->create([
        'source_key' => 'guardian',
        'author' => 'Jane',
    ]);
    $matching->categories()->attach($technology);

    $nonMatching = Article::factory()->create([
        'source_key' => 'nytimes',
        'author' => 'John',
    ]);
    $nonMatching->categories()->attach($sports);

    $result = $this->repository->getPreferredArticles($user->id, 10);

    expect($result->total())->toBe(1)
        ->and($result->first()->id)->toBe($matching->id);
});
