<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryContract
{
    public function getPreferences(int $userId): Model;

    public function updatePreferences(int $userId, array $preferences): Model;
}
