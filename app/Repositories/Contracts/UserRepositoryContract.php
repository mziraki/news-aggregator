<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryContract
{
    public function getPreferences(int $userId): User;

    public function updatePreferences(int $userId, array $preferences): User;
}
