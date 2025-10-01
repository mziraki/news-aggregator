<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getPreferences(int $userId): array
    {
        $user = User::findOrFail($userId);

        return [
            'preferred_sources' => $user->preferred_sources,
            'preferred_categories' => $user->preferred_categories,
            'preferred_authors' => $user->preferred_authors,
        ];
    }

    public function updatePreferences(int $userId, array $preferences): User
    {
        $user = User::findOrFail($userId);
        $user->update($preferences);

        return $user;
    }
}
