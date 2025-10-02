<?php

use App\Models\Category;
use App\Models\User;

it('retrieves preferences for authenticated user', function () {
    $payload = [
        'preferred_sources' => ['guardian'],
        'preferred_categories' => ['technology'],
        'preferred_authors' => ['John'],
    ];

    $this
        ->actingAs(User::factory()->create($payload))
        ->getJson('/api/v1/preferences')
        ->assertOk()
        ->assertJsonFragment($payload);
});

it('updates preferences for authenticated user', function () {
    Category::factory()->create(['name' => 'Technology', 'slug' => 'technology']);

    $this
        ->actingAs(User::factory()->create())
        ->putJson('/api/v1/preferences', [
            'preferred_sources' => ['guardian'],
            'preferred_categories' => ['technology'],
            'preferred_authors' => ['John'],
        ])
        ->assertOk()
        ->assertJsonFragment([
            'preferred_sources' => ['guardian'],
        ]);
});
