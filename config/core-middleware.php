<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Core Middleware
    |--------------------------------------------------------------------------
    |
    */
    'enabled' => env('CORE_MIDDLEWARE_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Allowable Environments
    |--------------------------------------------------------------------------
    | This specifies what environments the middleware will be enabled on.
    */
    'allowable-environments' => [
        'local',
        'development',
    ],

    /*
    |--------------------------------------------------------------------------
    | Loggers
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'loggers' => [
        'ray' => env('CORE_MIDDLEWARE_LOGGERS_RAY', true),
        'log' => env('CORE_MIDDLEWARE_LOGGERS_LOG', true),
    ],
];
