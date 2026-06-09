<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default search index
    |--------------------------------------------------------------------------
    |
    | This option controls the search index that gets queried when performing
    | search functions without explicitly selecting another index.
    |
    */

    'default' => env('STATAMIC_DEFAULT_SEARCH_INDEX', 'docs-'.config('docs.version')),

    /*
    |--------------------------------------------------------------------------
    | Search Indexes
    |--------------------------------------------------------------------------
    |
    | Here you can define all of the available search indexes.
    |
    */

    'indexes' => [

        'docs-'.config('docs.version') => [
            'driver' => env('SEARCH_DRIVER', 'meilisearch'),
            'searchables' => ['docs:*', 'storybook:*'],
            'fields' => [
                'title',
                'search_title',
                'content',
                'origin_title',
                'search_content',
                'additional_context',
                'hierarchy_lvl0',
                'hierarchy_lvl1',
                'url',
            ],
            'settings' => [
                'rankingRules' => [
                    'words',
                    'typo',
                    'proximity',
                    'attribute',
                    'exactness',
                    'origin_title:desc',
                    'hierarchy_lvl0:asc',
                ],
                'searchableAttributes' => [
                    'additional_context',
                    'hierarchy_lvl0',
                    'title',
                    'origin_title',
                    'search_title',
                    'search_content',
                    'hierarchy_lvl1',
                    'url',
                ],
            ],
            'content_retriever' => App\Search\RequestContentRetriever::class,
            'document_transformers' => [
                App\Search\DocTransformer::class,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Driver Defaults
    |--------------------------------------------------------------------------
    |
    | Here you can specify default configuration to be applied to all indexes
    | that use the corresponding driver. For instance, if you have two
    | indexes that use the "local" driver, both of them can have the
    | same base configuration. You may override for each index.
    |
    */

    'drivers' => [

        'local' => [
            'path' => storage_path('statamic/search'),
        ],

        'algolia' => [
            'credentials' => [
                'id' => env('ALGOLIA_APP_ID', ''),
                'secret' => env('ALGOLIA_SECRET', ''),
            ],
        ],

        'meilisearch' => [
            'credentials' => [
                'url' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
                'secret' => env('MEILISEARCH_KEY', ''),
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Search Defaults
    |--------------------------------------------------------------------------
    |
    | Here you can specify default configuration to be applied to all indexes
    | regardless of the driver. You can override these per driver or per index.
    |
    */

    'defaults' => [
        'fields' => ['title'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Indexing Queue
    |--------------------------------------------------------------------------
    |
    | Here you may configure the queue name and connection used when indexing
    | documents.
    |
    */

    'queue' => env('STATAMIC_SEARCH_QUEUE'),

    'queue_connection' => env('STATAMIC_SEARCH_QUEUE_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Chunk Size
    |--------------------------------------------------------------------------
    |
    | Here you can configure the chunk size used when indexing documents.
    | The higher you make it, the more memory it will use, but the quicker
    | the indexing process will be.
    |
    */

    'chunk_size' => 100,

];
