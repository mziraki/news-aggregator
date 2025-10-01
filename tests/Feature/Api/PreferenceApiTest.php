<?php

use App\Models\Category;
use App\Models\Source;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user, ['*']);

    Source::factory()->create(['key' => 'nyt', 'name' => 'Nyt']);
    Category::factory()->create(['name' => 'Sports', 'slug' => 'sports']);

    $this->repo = Mockery::mock(UserRepositoryInterface::class);
    $this->app->instance(UserRepositoryInterface::class, $this->repo);
});

it('retrieves preferences via repository', function () {
    $this->repo->shouldReceive('getPreferences')
        ->with($this->user->id)
        ->once()
        ->andReturn([
            'preferred_sources' => ['guardian'],
            'preferred_categories' => ['tech'],
            'preferred_authors' => ['Alice'],
        ]);

    $this->getJson('/api/v1/preferences')
        ->assertOk()
        ->assertJsonFragment(['preferred_sources' => ['guardian']]);
});

it('updates preferences via repository', function () {
    $payload = [
        'preferred_sources' => ['nyt'],
        'preferred_categories' => ['sports'],
        'preferred_authors' => ['Bob'],
    ];

    $this->repo->shouldReceive('updatePreferences')
        ->with($this->user->id, $payload)
        ->once()
        ->andReturn($this->user);

    $this->repo->shouldReceive('getPreferences')
        ->with($this->user->id)
        ->once()
        ->andReturn($payload);

    $this->putJson('/api/v1/preferences', $payload)
        ->assertOk()
        ->assertJsonFragment(['preferred_sources' => ['nyt']]);
});
