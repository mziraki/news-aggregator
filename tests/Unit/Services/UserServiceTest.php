<?php

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\UserService;

beforeEach(function () {
    $this->repository = Mockery::mock(UserRepositoryContract::class);
    $this->service = new UserService($this->repository);
});

it('gets preferences for a user', function () {
    $user = new User([
        'preferred_sources' => ['guardian'],
        'preferred_categories' => ['technology'],
        'preferred_authors' => ['Jane'],
    ]);

    $this->repository
        ->shouldReceive('getPreferences')
        ->once()
        ->with(1)
        ->andReturn($user);

    $result = $this->service->getPreferences(1);

    expect($result->preferred_sources)->toBe(['guardian'])
        ->and($result->preferred_categories)->toBe(['technology'])
        ->and($result->preferred_authors)->toBe(['Jane']);
});

it('updates preferences for a user', function () {
    $user = new User([
        'preferred_sources' => ['nytimes'],
        'preferred_categories' => ['sports'],
        'preferred_authors' => ['John'],
    ]);

    $this->repository
        ->shouldReceive('updatePreferences')
        ->once()
        ->with(1, [
            'preferred_sources' => ['nytimes'],
            'preferred_categories' => ['sports'],
            'preferred_authors' => ['John'],
        ])
        ->andReturn($user);

    $result = $this->service->updatePreferences(1, [
        'preferred_sources' => ['nytimes'],
        'preferred_categories' => ['sports'],
        'preferred_authors' => ['John'],
    ]);

    expect($result->preferred_sources)->toBe(['nytimes'])
        ->and($result->preferred_categories)->toBe(['sports'])
        ->and($result->preferred_authors)->toBe(['John']);
});
