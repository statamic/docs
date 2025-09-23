<?php

return [

    'version' => env('STATAMIC_DOCS_VERSION', '5'),

    'versions' => [
        [
            'version' => '6',
            'branch' => '6.x',
            'url' => 'https://v6.statamic.dev',
            'alpha' => true,
        ],
        [
            'version' => '5',
            'branch' => '5.x',
            'url' => 'https://statamic.dev',
        ],
    ],

];
