<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getPreferences(int $userId): array;

    public function updatePreferences(int $userId, array $preferences): User;
}
