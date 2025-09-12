<?php

return [

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'assets' => [
            'driver' => 'local',
            'root' => public_path('img'),
            'url' => '/img',
            'visibility' => 'public',
        ],
    ],

];
