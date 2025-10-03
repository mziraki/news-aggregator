<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    protected function model(): string
    {
        return User::class;
    }

    public function getPreferences(int $userId): Model
    {
        return $this->query()->findOrFail($userId, [
            'preferred_sources',
            'preferred_categories',
            'preferred_authors',
        ]);
    }

    public function updatePreferences(int $userId, array $preferences): Model
    {
        $user = $this->query()->findOrFail($userId);
        $user->update($preferences);

        return $user;
    }
}
