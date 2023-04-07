<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Core Middleware
    |--------------------------------------------------------------------------
    | This specifies whether the middleware is enabled or not.
    |
    */
    'enabled' => env('CORE_MIDDLEWARE_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Allowable Environments
    |--------------------------------------------------------------------------
    | This specifies what environments the middleware will be enabled on.
    |
    */
    'allowable-environments' => [
        'local',
        'development',
    ],

    /*
    |--------------------------------------------------------------------------
    | Loggers
    |--------------------------------------------------------------------------
    | This specifies what loggers are enabled, at the current time only Ray and
    | Log are supported.
    |
    */
    'loggers' => [
        'ray' => env('CORE_MIDDLEWARE_LOGGERS_RAY', true),
        'log' => env('CORE_MIDDLEWARE_LOGGERS_LOG', true),
    ],
];
