<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Repository Configuration
    |--------------------------------------------------------------------------
    |
    | This is where you configure the settings related to repositories.
    |
    */

    'repository' => [
        'namespace' => env('REPOSITORY_NAMESPACE', 'Repositories'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Configuration
    |--------------------------------------------------------------------------
    |
    | This is where you configure the settings related to services.
    |
    */
    'service' => [
        'namespace' => env('SERVICE_NAMESPACE', 'Services'),
    ],
];
