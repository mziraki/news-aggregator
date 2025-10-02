<?php

use App\Jobs\FetchNewsProviderJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

it('dispatches jobs for each news provider', function () {
    Queue::fake();

    $this->artisan('news:fetch')->assertExitCode(0);

    Queue::assertPushed(FetchNewsProviderJob::class, Str::of(config('sources.keys'))->explode(',')->count());
});
