<?php

return [
    /*
    |------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may be
    | executed in web browsers.
    |
    */

    'paths' => [
        'api/*',
        'teacher/*',
        'student/*',
        'classroom/*',
        'subject/*',
        'course/*',
        'coef/*',
    ],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];