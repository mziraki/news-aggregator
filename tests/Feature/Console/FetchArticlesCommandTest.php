<?php

use App\Services\News\NewsAggregatorService;

it('calls aggregator service when running fetch command', function () {
    $mock = Mockery::mock(NewsAggregatorService::class);
    $mock->shouldReceive('fetchAndStore')->once()->andReturn([]);
    $this->app->instance(NewsAggregatorService::class, $mock);

    $this->artisan('news:fetch')->assertExitCode(0);
});
