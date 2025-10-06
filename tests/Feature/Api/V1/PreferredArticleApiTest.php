<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('lists preferred articles for authenticated user', function () {
    Sanctum::actingAs(User::factory()->create());

    $this
        ->getJson(route('api.v1.articles.preferred.index', absolute: false))
        ->assertOk();
});
