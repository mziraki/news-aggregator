<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreferenceUpdateRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function __construct(protected UserRepositoryInterface $users) {}

    public function show(Request $request)
    {
        return response()->json($this->users->getPreferences($request->user()->id));
    }

    public function update(PreferenceUpdateRequest $request)
    {
        $user = $this->users->updatePreferences($request->user()->id, $request->validated());

        return response()->json([
            'message' => 'Preferences updated successfully',
            'preferences' => $this->users->getPreferences($user->id),
        ]);
    }
}
