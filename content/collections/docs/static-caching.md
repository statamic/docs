---
title: 'Static Caching'
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568748305
blueprint: page
id: ffa24da8-3fee-4fc9-a81b-fcae8917bd74
intro: |
    There is absolutely nothing faster on the web than static pages. And to that end, Statamic can cache static pages and pass off routing to Apache or Nginx through reverse proxying. It sounds much harder than is.
---
Certain features, like forms with server-side validation, don’t work with static page caching. As long as you understand that, you can leverage this feature for literally the fastest sites possible. Let’s take a look!

## Caching strategies

You can set up various caching strategies configured in different ways. Out of the box, you will find two pre-configured strategies - one for each supported driver.

``` php
return [
    'strategy' => 'half',
    
    'strategies' => [
        'half' => [
            'driver' => 'application',
        ],
        'full' => [
            'driver' => 'file',
        ]
    ]
];
```

Set `strategy` to the name of the strategy you wish to use. Set it to `null` to disable static caching completely.

## Application Driver

The application driver will store your cached page content within Laravel's cache.
We refer to this as <mark>half measure</mark>.

This will still run every request through the full Statamic bootstrapping process but will serve all request data from a cache, speeding up load times often by half or more. This is an easy, one-and-done setting.

``` php
return [
    'strategy' => 'half',

    'strategies' => [
        'half' => [
            'driver' => 'application',
        ]
    ]
];
```

## File Driver

The file driver will generate completely static `.html` pages ready for your web server to serve directly. This means that the HTML files will be
loaded before it even reaches PHP. 

We refer to this as <mark>full measure</mark>. Super speed!

``` php
return [
    'strategy' => 'full',

    'strategies' => [
        'full' => [
            'driver' => 'file',
            'path' => public_path('static'),
        ]
    ]
];
```

## Server rewrite rules

Depending on which type of server you're running, you will need to configure its rewrite rules when using full measure caching.

### Apache

On Apache servers, you can define rewrite rules inside an `.htaccess` file:

``` htaccess
RewriteCond %{DOCUMENT_ROOT}/static/%{REQUEST_URI}_%{QUERY_STRING}\.html -s
RewriteCond %{REQUEST_METHOD} GET
RewriteRule .* static/%{REQUEST_URI}_%{QUERY_STRING}\.html [L,T=text/html]
```

### Nginx

On Nginx servers, you will need to edit your `.conf` files. They are not located within your project, and may be in
a slighly different place depending on your server setup.

Some applications like [Laravel Forge](https://forge.laravel.com) may let you edit your nginx.conf from within the UI.

``` nginx
location / {
  try_files /static${uri}_${args}.html $uri /index.php?$args;
}
```

### IIS

On Windows IIS servers, your rewrite rules can be placed in a `web.config` file.

``` xml
<rule name="Static Caching" stopProcessing="true">
  <match url="^(.*)"  />
  <action type="Rewrite" url="/static/{R:1}_{QUERY_STRING}.html"  />
</rule>            
```

## Excluding pages

You may add a list of URLs you wish to exclude from being cached. You may want to exclude pages that need to always be dynamic, such as forms and listings with `sort="random"`.

``` php
return [
    'exclude' => [
        '/contact',
        '/blog/*',  // Excludes /blog/post-name, but not /blog  
        '/news*',   // Exclude /news, /news/article, and /newspaper
    ]
];
```

Query strings will be omitted from exclusion rules automatically, regardless of whether wildcards are used. For example, choosing to ignore `/blog` will also ignore `/blog?page=2`, etc.

## Invalidation

A statically cached page will be served until it is invalidated in one way or another. You have a number of options for how to handle it.

### Time limit

When using the application driver, you may specify the `expiry` time in minutes. After this length of time, the next request will be served fresh. By leaving the expiry setting `null`, it will never expire, except when you manually run `php artisan cache:clear`.

When using the file driver, since the generated html files will be served before PHP ever gets hit, the expiry option is not available.

### When saving

When saving content, the corresponding item’s URL will be flushed from the static cache automatically.

You may also set specific rules for invalidating other pages when content is saved. For example:

``` php
return [
    'invalidation' => [
        'rules' => [
            'collections' => [
                'blog' => [
                    'urls' => [
                        '/blog',
                        '/blog/category/*',
                        '/',
                    ]
                ],
            ],
            'taxonomies' => [
                'tags' => [
                    'urls' => [
                        '/blog',
                        '/blog/category/*',
                        '/',
                    ]
                ]
            ]
        ]
    ]
];
```

This says:

- “when an entry in the blog collection is saved, we should invalidate the /blog page, any pages beginning with /blog/category/, and the home page.”
- “when a term in the tags taxonomy is saved, we should invalidate those same pages”

Of course, you may add as many collections and taxonomies as you need.

You may also choose to invalidate the entire static cache by specifying `all`.

``` php
return [
    'invalidation' => [
        'rules' => 'all',
    ]
];
```

### By force

To clear the static file cache you can run `php please clear:static` (and/or delete the appropriate static file locations).

## File Locations

When using the file driver, the static html files are stored in the `static` directory of your webroot, but you can change it.

``` php
return [

    'strategies' => [
        'full' => [
            'driver' => 'file',
            'path' => public_path('static'),
        ]
    ]
];
```

You will need to update your appropriate server rewrite rules.
