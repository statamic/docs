<?php

use Statamic\Stache\Stores;

return [

    'watcher' => env('STATAMIC_FILE_WATCHER', true),

    'stores' => [

        'taxonomies' => [
            'class' => Stores\TaxonomiesStore::class,
            'directory' => base_path('content/taxonomies'),
        ],

        'terms' => [
            'class' => Stores\TermsStore::class,
            'directory' => base_path('content/taxonomies'),
        ],

        'collections' => [
            'class' => Stores\CollectionsStore::class,
            'directory' => base_path('content/collections'),
        ],

        'entries' => [
            'class' => Stores\EntriesStore::class,
            'directory' => base_path('content/collections'),
        ],

        'navigation' => [
            'class' => Stores\NavigationStore::class,
            'directory' => base_path('content/navigation'),
        ],

        'globals' => [
            'class' => Stores\GlobalsStore::class,
            'directory' => base_path('content/globals'),
        ],

        'asset-containers' => [
            'class' => Stores\AssetContainersStore::class,
            'directory' => base_path('content/assets'),
        ],

        'users' => [
            'class' => Stores\UsersStore::class,
            'directory' => base_path('users'),
        ],

    ]

];
