<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\UserServiceContract;
use Illuminate\Database\Eloquent\Model;

class UserService implements UserServiceContract
{
    public function __construct(protected UserRepositoryContract $repository) {}

    public function getPreferences(int $userId): Model
    {
        return $this->repository->getPreferences($userId);
    }

    public function updatePreferences(int $userId, array $preferences): Model
    {
        return $this->repository->updatePreferences($userId, $preferences);
    }
}
