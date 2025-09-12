<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Markdown Parser Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may define the configuration arrays for each markdown parser.
    | You may use the base CommonMark options as well as any extensions'
    | options here. The available options are in the CommonMark docs.
    |
    | https://statamic.dev/extending/markdown#configuration
    |
    */

    'configs' => [

        'default' => [
            'heading_permalink' => [
                'symbol' => '',
                'id_prefix' => '',
                'fragment_prefix' => '',
                'apply_id_to_heading' => true,
                'html_class' => 'c-anchor',
                'aria_hidden' => false,
            ],
        ],

    ],

];
