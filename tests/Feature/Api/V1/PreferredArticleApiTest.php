<?php

use App\Models\User;

it('lists preferred articles for authenticated user', function () {
    $this
        ->actingAs(User::factory()->create())
        ->getJson('/api/v1/articles/preferred')
        ->assertOk();
});
