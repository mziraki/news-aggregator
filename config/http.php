<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default HTTP Client Options
    |--------------------------------------------------------------------------
    |
    | Here you can configure default options for Laravel's HTTP client.
    | These values will be applied to all requests unless overridden.
    |
    */

    'timeout' => env('HTTP_CLIENT_TIMEOUT', 30),

    'connect_timeout' => env('HTTP_CLIENT_CONNECT_TIMEOUT', 10),

];
