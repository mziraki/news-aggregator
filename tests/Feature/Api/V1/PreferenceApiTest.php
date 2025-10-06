<?php

use App\Models\Category;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('retrieves preferences for authenticated user', function () {
    $payload = [
        'preferred_sources' => ['guardian'],
        'preferred_categories' => ['technology'],
        'preferred_authors' => ['John'],
    ];

    Sanctum::actingAs(User::factory()->create($payload));

    $this
        ->getJson(route('api.v1.preferences.show', absolute: false))
        ->assertOk()
        ->assertJsonFragment($payload);
});

it('updates preferences for authenticated user', function () {
    Sanctum::actingAs(User::factory()->create());

    Category::factory()->create(['name' => 'Technology', 'slug' => 'technology']);

    $this
        ->putJson(route('api.v1.preferences.update', absolute: false), [
            'preferred_sources' => ['guardian'],
            'preferred_categories' => ['technology'],
            'preferred_authors' => ['John'],
        ])
        ->assertOk()
        ->assertJsonFragment([
            'preferred_sources' => ['guardian'],
        ]);
});
