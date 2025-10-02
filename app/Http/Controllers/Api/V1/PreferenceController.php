<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreferenceUpdateRequest;
use App\Http\Resources\PreferenceResource;
use App\Services\Contracts\UserServiceContract;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function __construct(protected UserServiceContract $service) {}

    public function show(Request $request)
    {
        return PreferenceResource::make($this->service->getPreferences($request->user()->getKey()));
    }

    public function update(PreferenceUpdateRequest $request)
    {
        $user = $this->service->updatePreferences($request->user()->getKey(), $request->validated());

        return response()->json([
            'message' => 'Preferences updated successfully',
            'data' => $this->service->getPreferences($user->getKey())->toArray(),
        ]);
    }
}
