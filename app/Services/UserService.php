<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\UserServiceContract;

class UserService implements UserServiceContract
{
    public function __construct(protected UserRepositoryContract $repository) {}

    public function getPreferences(int $userId): User
    {
        return $this->repository->getPreferences($userId);
    }

    public function updatePreferences(int $userId, array $preferences): User
    {
        return $this->repository->updatePreferences($userId, $preferences);
    }
}
