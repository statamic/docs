<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Permanent Redirects
    |--------------------------------------------------------------------------
    |
    | While it's recommended to add permanent redirects (301s) on the server
    | for performence, you may also define them here for your convenience.
    |
    */

    'redirect' => [
        '/entries' => '/collections-and-entries',
        '/collections' => '/collections-and-entries',
    ],

    /*
    |--------------------------------------------------------------------------
    | Action Route Prefix
    |--------------------------------------------------------------------------
    |
    | Some extensions may provide routes that go through the frontend of your
    | website. These URLs begin with the following prefix. We've chosen an
    | unobtrusive default but you are free to select whatever you want.
    |
    */

    'action' => '!',

];
