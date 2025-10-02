<?php

use App\Http\Resources\PreferenceResource;
use App\Models\User;

it('transforms preferences into the expected array', function () {
    $preferences = [
        'preferred_sources' => ['guardian', 'nytimes'],
        'preferred_categories' => ['technology', 'science'],
        'preferred_authors' => ['Jane', 'John'],
    ];

    $user = User::factory()->create($preferences);

    $resource = (new PreferenceResource($user))->resolve();

    expect($resource)->toMatchArray($preferences);
});
