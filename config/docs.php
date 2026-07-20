<?php

return [

    'version' => env('STATAMIC_DOCS_VERSION', '6'),

    'versions' => [
        [
            'version' => '6',
            'branch' => '6.x',
            'url' => env('STATAMIC_DOCS_V6_URL', 'https://statamic.dev'),
        ],
        [
            'version' => '5',
            'branch' => '5.x',
            'url' => env('STATAMIC_DOCS_V5_URL', 'https://v5.statamic.dev'),
        ],
    ],

];
