<?php

use App\Models\Category;
use App\Models\Source;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user, ['*']);
});

it('saves preferences to DB', function () {
    // Create valid entries
    Source::factory()->create(['key' => 'guardian', 'name' => 'Guardian']);
    Category::factory()->create(['name' => 'Technology', 'slug' => 'technology']);

    $payload = [
        'preferred_sources' => ['guardian'],
        'preferred_categories' => ['technology'],
        'preferred_authors' => ['Alice'],
    ];

    $this->putJson('/api/v1/preferences', $payload)
        ->assertOk()
        ->assertJsonFragment(['preferred_sources' => ['guardian']]);

    expect($this->user->fresh()->preferred_sources)->toBe(['guardian']);
});

it('retrieves preferences from DB', function () {
    $this->user->update([
        'preferred_sources' => ['nyt'],
        'preferred_categories' => ['sports'],
        'preferred_authors' => ['Bob'],
    ]);

    $this->getJson('/api/v1/preferences')
        ->assertOk()
        ->assertJsonFragment(['preferred_sources' => ['nyt']]);
});
