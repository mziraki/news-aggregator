<?php

namespace App\Services\Contracts;

use App\Models\User;

interface UserServiceContract
{
    public function getPreferences(int $userId): User;

    public function updatePreferences(int $userId, array $preferences): User;
}
