<?php

use App\Models\User;
use App\Repositories\UserRepository;

beforeEach(function () {
    $this->repository = new UserRepository;
});

it('gets preferences for a user', function () {
    $user = User::factory()->create([
        'preferred_sources' => ['guardian', 'nytimes'],
        'preferred_categories' => ['technology'],
        'preferred_authors' => ['John'],
    ]);

    $result = $this->repository->getPreferences($user->id);

    expect($result->preferred_sources)->toBe(['guardian', 'nytimes'])
        ->and($result->preferred_categories)->toBe(['technology'])
        ->and($result->preferred_authors)->toBe(['John']);
});

it('updates preferences for a user', function () {
    $user = User::factory()->create([
        'preferred_sources' => [],
        'preferred_categories' => [],
        'preferred_authors' => [],
    ]);

    $updated = $this->repository->updatePreferences($user->id, [
        'preferred_sources' => ['guardian'],
        'preferred_categories' => ['sports'],
        'preferred_authors' => ['John'],
    ]);

    expect($updated->preferred_sources)->toBe(['guardian'])
        ->and($updated->preferred_categories)->toBe(['sports'])
        ->and($updated->preferred_authors)->toBe(['John']);
});
