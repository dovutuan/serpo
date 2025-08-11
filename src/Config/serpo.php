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

    /*
    |--------------------------------------------------------------------------
    | Criteria Configuration
    |--------------------------------------------------------------------------
    |
    | This is where you configure the settings related to criteria classes.
    | Criteria are used to encapsulate query conditions and can be applied
    | dynamically to repositories, making your data retrieval logic more
    | reusable and maintainable.
    |
    */
    'criteria' => [
        'namespace' => env('CRITERIA_NAMESPACE', 'Criteria'),
    ],
];
