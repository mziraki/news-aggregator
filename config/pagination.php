<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Pagination Settings
    |--------------------------------------------------------------------------
    | These values control the default pagination behavior across your app.
    | You can override them per query, but these will be used as defaults.
    |
    */

    // Default number of items per page for API endpoints
    'per_page' => env('PAGINATION_PER_PAGE', 20),

    // Max number of items per page for API endpoints
    'max_per_page' => env('PAGINATION_MAX_PER_PAGE', 50),

];
