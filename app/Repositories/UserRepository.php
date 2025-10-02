<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    public function getPreferences(int $userId): User
    {
        return User::findOrFail($userId, [
            'preferred_sources',
            'preferred_categories',
            'preferred_authors',
        ]);
    }

    public function updatePreferences(int $userId, array $preferences): User
    {
        $user = User::findOrFail($userId);
        $user->update($preferences);

        return $user;
    }
}
