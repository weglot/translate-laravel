<?php

return [
    'api_key' => env('WG_API_KEY'),
    'original_language' => config('app.locale'),
    'destination_languages' => [
        'fr'
    ],
    'exclude_blocks' => [],
    'cache' => false,

    'laravel' => [
        'controller_namespace' => 'App\Http\Controllers'
    ]
];