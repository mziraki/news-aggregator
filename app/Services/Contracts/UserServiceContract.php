<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UserServiceContract
{
    public function getPreferences(int $userId): Model;

    public function updatePreferences(int $userId, array $preferences): Model;
}
