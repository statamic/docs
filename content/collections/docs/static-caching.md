---
title: 'Static Caching'
template: page
blueprint: page
intro: |
    Nothing loads faster than static pages. Instead of rendering pages dynamically on demand, Statamic can cache static pages and pass routing to Apache or Nginx with reverse proxying.
id: ffa24da8-3fee-4fc9-a81b-fcae8917bd74
---
## Important preface

Certain features — such as forms with server-side validation, page protection, or content randomization — may not work with static page caching. (You may want to check out the [nocache tag](/tags/nocache) though.) As long as you understand that, you can leverage static caching for maximum performance.

Whatever is on the page the first time it's visited is what will be cached for all users. For example, if you're using page protection and a user who has access visits the page, it'll be accessible to everyone.

:::tip
You can **alternatively** use the [static site generator](https://github.com/statamic/ssg) to pre-generate and deploy **fully static HTML sites**.
:::

## Caching strategies

Each caching strategy can be configured independently. Inside `config/statamic/static_caching.php` you will find two pre-configured strategies - one for each supported driver.

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

Set `strategy` to the name of the strategy you wish to use, or `null` to disable static caching completely.

## Application driver

The application driver will store your cached page content within Laravel's cache. We refer to this as **half measure**.

This will still run every request through a full instance of Statamic but will serve all request data from a pre-rendered cache, speeding up load times often by half or more. This is an easy, one-and-done setting.

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

:::tip
You may use the [nocache tag](/tags/nocache) to keep parts of your pages dynamic.
:::

## File driver

The file driver will generate completely static `.html` pages ready for your web server to serve directly. This means that the HTML files will be loaded before it even reaches PHP.

We refer to this as <mark>full measure</mark>. This is probably the lightning you seek. ⚡️

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

:::tip Heads up!
When using full-measure caching, the [nocache tag](/tags/nocache) will rely on JavaScript.
:::


### Permissions

Using the file driver, you can configure the permissions for the directories and files that are getting created using the `static_caching.strategies.full` config option.

```php
'strategies' => [
    'full' => [
        'driver' => 'file',
        'path' => public_path('static'),
        'permissions' => [ // [tl! focus]
            'directory' => 0755, // [tl! focus]
            'file' => 0644, // [tl! focus]
        ], // [tl! focus]
    ],
]
```

## Server rewrite rules

You will need to configure its rewrite rules when using full measure caching. Here are the rules for each type of server.

:::tip
If you're using Laravel Herd or Laravel Valet, you don't need to worry about configuring rewrite rules locally. They will automatically handle the rewrite rules for you.
:::

### Apache

On Apache servers, you can define rewrite rules inside an `.htaccess` file:

``` htaccess
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{QUERY_STRING} !live-preview
RewriteRule ^ index.php [L]

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{QUERY_STRING} live-preview
RewriteRule ^ index.php [L]

RewriteCond %{DOCUMENT_ROOT}/static/%{REQUEST_URI}_%{QUERY_STRING}\.html -s
RewriteCond %{REQUEST_METHOD} GET
RewriteRule .* static/%{REQUEST_URI}_%{QUERY_STRING}\.html [L,T=text/html]
```

:::tip
When you have the `ignore_query_strings` option enabled, replace the last chunk of the `.htaccess` snippet with this:

``` htaccess
RewriteCond %{DOCUMENT_ROOT}/static%{REQUEST_URI}\.html -f
RewriteRule ^ static%{REQUEST_URI}\.html [L]

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```
:::

### Nginx

:::tip
If you're using [Laravel Forge](https://forge.laravel.com) and selected the "Statamic" type when creating your site, this will already be configured for you.
:::

On Nginx servers, you will need to edit your `.conf` files. They are not located within your project, and may be in a slightly different place depending on your server setup.

If you're using a service like [Laravel Forge](https://forge.laravel.com) or [Ploi](https://ploi.io/statamic), you can edit your `nginx.conf` from within the UI.

``` nginx
set $try_location @static;

if ($request_method != GET) {
    set $try_location @not_static;
}

if ($args ~* "live-preview=(.*)") {
    set $try_location @not_static;
}

location / {
    try_files $uri $try_location;
}

location @static {
    try_files /static${uri}_$args.html $uri $uri/ /index.php?$args;
}

location @not_static {
    try_files $uri /index.php?$args;
}
```

:::tip
When you have the `ignore_query_strings` option enabled, you should update the `try_files` line inside the `@static` block:

``` nginx
location @static {
    try_files /static${uri}_$args.html $uri $uri/ /index.php?$args; # [tl! remove]
    try_files /static${uri}_.html $uri $uri/ /index.php?$args; # [tl! add]
}
```
:::


:::tip
If your site needs to support URLs with a trailing slash, make sure to update the NGINX config:

``` nginx
location / {
    try_files $uri $try_location; # [tl! remove]
    try_files $uri $uri/ $try_location; # [tl! add]
}

location @static {
    try_files /static${uri}_$args.html $uri $uri/ /index.php?$args; # [tl! remove]
    rewrite ^/(.*)/$ /$1 last; # [tl! add]
    try_files /static${uri}_$args.html /static${uri}/_$args.html $uri $uri/ /index.php?$args; # [tl! add]
}

location @not_static {
    try_files $uri /index.php?$args; # [tl! remove]
    try_files $uri $uri/ /index.php?$args; # [tl! add]
}
```
:::


### IIS

On Windows IIS servers, your rewrite rules can be placed in a `web.config` file.

``` xml
<rule name="Static Caching" stopProcessing="true">
  <match url="^(.*)"  />
  <action type="Rewrite" url="/static/{R:1}_{QUERY_STRING}.html"  />
</rule>
```

## Warming the static cache

Before users visit your website, you may wish to warm the static cache to make first time loads much faster. To do this, run:

```
php please static:warm
```

The `static:warm` command supports various arguments:

* **`--queue`**
    Indicates that URIs should be warmed on the queue (in the background).
* **`--insecure`**
    Allows the command to skip SSL verification. This can come in handy when running the site behind a reverse proxy or when using self-signed certificates, for example.
* **`--user` and `--password`**
    Allows you to specify credentials to be used when your site is secured with [HTTP Basic Authentication](https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#basic_authentication_scheme). Otherwise, you might end up with a `401 Unauthorized` error running the command.
* **`--uncached`**
    Ensure that only *uncached* pages are warmed. Perfect for when you just want to 'fill in the gaps' in your cache after some URLs were invalidated, without visiting every single URL in your website. This avoids unnecessary server load.
* **`--include` and `--exclude`**
    Accepts a comma-separated list of URLs you'd like to be included/excluded in the warming process.
    Example: `--include='/about,/contact,/blog/*'`
* **`--max-depth`**
    Allows you to specify the max depth of pages that should be warmed.
    For example with `--max-depth=1` it will visit pages like `/about` and `/products` but not `/products/cool-new-shoes-1` or `/any/other/path/that/is/too/deep`.
* **`--max-requests`**
    Limits the number of requests made by the command. Likely makes the most sense to be used alongside the `--uncached` option.
* **`--header`**
    Allows you to specify custom HTTP headers to be sent with each request. Can be used multiple times to set multiple headers. Useful for APIs, protected routes, or any scenario where custom headers are required. 

    For example: `--header="Authorization: Bearer your_token" --header="X-Ignore-Cache: true"`

    You can find [practical examples](#custom-headers) of this parameter below.

Depending on your site's setup, it might be a good idea to add this command to your deployment script.

### Concurrency

You may configure the amount of concurrent requests when warming the static cache in your strategy.

By default the pool will use `25`, but feel free to adjust it up or down based on your server's resources.


```php
    'strategies' => [
        'full' => [
            'driver' => 'file',
            'path' => public_path('static'),
            'lock_hold_length' => 0,
            'warm_concurrency' => 10, // [tl! highlight]
        ],
    ],
```

:::tip
Lower the `warm_concurrency` to reduce the overhead and slow the process down, raise it to warm faster by using more CPU.
:::

### Queuing

When you're using a queue driver other than `sync`, Statamic will push the warming out to the queue.

If needed, you can explicitly tell Statamic which queue and queue connection should be used when warming the static cache:

```php
// config/statamic/static_caching.php

'warm_queue' => env('STATAMIC_STATIC_WARM_QUEUE'),

'warm_queue_connection' => env('STATAMIC_STATIC_WARM_QUEUE_CONNECTION'),
```

```
STATAMIC_STATIC_WARM_QUEUE=warming
STATAMIC_STATIC_WARM_QUEUE_CONNECTION=database
```

### Warming additional URLs

Statamic will automatically warm pages for entries, taxonomy terms and any basic `Route::statamic()` routes. If you wish to warm additional URLs as part of the `static:warm` command, you may add a hook into your `AppServiceProvider`'s `boot` method:

```php
use Statamic\Console\Commands\StaticWarm;

class AppServiceProvider
{
    public function boot()
    {
        StaticWarm::hook('additional', function ($urls, $next) {
            return $next($urls->merge([
                '/custom-1',
                '/custom-2',
                'https://different-domain.com/custom-3',
            ]));
        });
    }
}
```

When you're adding a lot of additional URLs, you may want to use a dedicated class instead:

```php
use App\StaticWarmExtras;
use Statamic\Console\Commands\StaticWarm;

class AppServiceProvider
{
    public function boot()
    {
        StaticWarm::hook('additional', function ($urls, $next) {
            return $next($urls->merge(StaticWarmExtras::handle()));
        });
    }
}
```

### Custom headers

The `--headers` option can be used in advanced scenarios to control how the static cache is warmed. Here are some practical examples:

#### Bypassing cache for refreshes with Nginx

If you have custom Nginx rules, you can check for a specific header (e.g., `X-Cache-Refresh: 1`) and bypass the `try_files` static cache, forcing a fresh request to the backend. For example:

```nginx
location / {
    if ($http_x_cache_refresh = "1") {
        proxy_pass http://127.0.0.1:8000; # your statamic server
        break;
    }
    try_files $uri $try_location;
}
```

Then, you can run:

```
php please static:warm --header="X-Cache-Refresh: 1"
```

#### Warming behind authentication

If your site is protected by HTTP authentication or expects a specific header, you can use `--header` to provide the necessary credentials or tokens so the warm requests are not blocked. For example:

```
php please static:warm --header="Authorization: Bearer your_token"
```

This ensures the cache warming requests are accepted by your backend even when authentication is required.


## Excluding Pages

You may wish to exclude certain URLs from being cached.

```php
return [
    'exclude' => [
        'class' => null,
        'urls' => [
            '/contact', // [tl! add]
            '/blog/*',  // Excludes /blog/post-name, but not /blog [tl! add]
            '/news*',   // Exclude /news, /news/article, and /newspaper [tl! add]
        ],
    ],
];
```

Query strings will be omitted from exclusion rules automatically, regardless of whether wildcards are used. For example, choosing to ignore `/blog` will also ignore `/blog?page=2`, etc.

:::tip
Rather than excluding entire pages, you may consider using the [nocache tag](/tags/nocache) to keep parts of your page dynamic, like forms, listings, or randomized areas.
:::

:::tip Another tip
CSRF tokens will automatically be excluded from the cache. You don't even need to use a `nocache` tag for that. ([With some exceptions](#csrf-tokens))
:::

If you'd like to dynamically exclude URLs from being cached (for example: if you want to add a "Exclude from Cache" toggle to entries), you can create your own excluder class:

```php
// config/statamic/static_caching.php

return [
    'exclude' => [
        'class' => App\StaticCaching\CustomExcluder::class, // [tl! add]
        'urls' => [],
    ],
];
```

```php
// app/StaticCaching/CustomExcluder.php

<?php

namespace App\StaticCaching;

use Statamic\Support\Str;
use Statamic\StaticCaching\UrlExcluder;

class CustomExcluder implements UrlExcluder
{
    public function __construct(protected string $baseUrl, protected array $exclusions)
    {
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getExclusions(): array
    {
        return $this->exclusions;
    }

    public function isExcluded(string $url): bool
    {
        // Your custom logic here.
        // Return `true` for any URLs you wish to be excluded.
        return false;
    }
}
```

Alternatively, you may also prevent URLs from being cached by adding the `X-Statamic-Uncacheable: true` header to requests. 

## Invalidation

A statically cached page will be served until it is invalidated. You have several options for how to invalidate your cache.

### Time Limit

When using the application driver, you may specify the `expiry` time in minutes in the `static_caching.php` config file. After this length of time, the next request will be served fresh. By leaving the expiry setting `null`, it will never expire, except when you manually run `php artisan cache:clear`.

**The expiry option is not available when using the file driver.** The generated HTML files will be served before PHP ever gets hit, and there's just nothing we can do about that.

### When Saving

When saving content, the corresponding item’s URL will be flushed from the static cache automatically.

You may also set specific rules for invalidating other pages when content is saved. For example:

``` php
return [
    'invalidation' => [
        'class' => null,
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
            ],
            'globals' => [
                'settings' => [
                    'urls' => [
                        '/*'
                    ]
                ]
            ],
            'navigation' => [
                'links' => [
                    'urls' => [
                        '/*'
                    ]
                ]
            ]
        ]
    ]
];
```

#### Explanation

- “when an entry in the blog collection is saved, we should invalidate the /blog page, any pages beginning with /blog/category/, and the home page.”
- “when a term in the tags taxonomy is saved, we should invalidate those same pages”
- “when the settings global set is saved, we invalidate all urls”
- “when the links navigation is saved, we invalidate all urls”

You may add as many collections and taxonomies as you need.

You may also choose to invalidate the entire static cache by specifying `all`.

``` php
return [
    'invalidation' => [
        'class' => null,
        'rules' => 'all', // [tl! highlight]
    ],
];
```

### On a schedule

If you have the scheduler running, Statamic will use the same set of rules mentioned above, but when scheduled entries are due to become active.

For example, if you schedule an entry for Friday at 8am, and you have the scheduler running, appropriate pages will be invalidated just as if you had clicked saved on that entry at Friday at 8am.

[Learn how to use the scheduler](/scheduling)

### Custom invalidator class

You can also specify a custom invalidator class to **programmatically determine which URLs should be invalidated**. To achieve that, override or extend [the default invalidator class](https://github.com/statamic/cms/blob/01f8dfd1cbe304be1848d2e4be167a0c49727170/src/StaticCaching/DefaultInvalidator.php).

```php
return [
    'invalidation' => [
        'class' => App\StaticCaching\CustomInvalidator::class,  // [tl! highlight]
        'rules' => [],
    ],
];
```

It's worth noting that the container binding for the Default Invalidator won't be used now, so you'll need to bind it yourself in your `AppServiceProvider`:

```php
use App\StaticCaching\CustomInvalidator;
use Statamic\StaticCaching\Cacher;

class AppServiceProvider
{
    public function boot()
    {
        $this->app->bind(CustomInvalidator::class, function ($app) {
            return new CustomInvalidator(
                $app[Cacher::class],
                $app['config']['statamic.static_caching.invalidation.rules']
            );
        });
    }
}
```

In your class you can then define the logic that decides how URLs should get invalidated.

```php
// app/StaticCaching/CustomInvalidator.php

<?php

namespace App\StaticCaching;

use Statamic\Entries\Entry;
use Statamic\StaticCaching\DefaultInvalidator;

class CustomInvalidator extends DefaultInvalidator
{
    public function invalidate($item)
    {
        // Flushes everything by setting the invalidation rules to `all`.
        if ($this->rules === 'all') {
            return $this->cacher->flush();
        }

        $urls = [];

        // Invalidates entries from the `events` collection.
        if ($item instanceof Entry && $item->collectionHandle() === 'events') {
            $urls[] = $item->uri();
        }

        // Flush the URLs we've added to the $urls array.
        if (count($urls) >= 1) {
            $this->cacher->invalidateUrls($urls);

            return;
        }

        // Otherwise, when the $urls array is empty, fallback to the default invalidation logic.
        parent::invalidate($item);
    }
}
```

### By force

To clear the static file cache you can run `php please static:clear` (and/or delete the appropriate static file locations).

## File locations

When using the file driver, the static HTML files are stored in the `static` directory of your webroot, but you can change it.

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


## Query parameters

By default, Statamic will cache all pages with the same URL but different query parameters separately. This can be helpful if you're using pagination or displaying pages differently based on user input.

However, if you wish, you can disable this behaviour so each URL will only be cached once, regardless of query parameters:

```php
return [
    'ignore_query_strings' => true,
];
```

### Allowed and disallowed query parameters

If you're using half measure caching, you may specify which query parameters Statamic should include in it's "normalized" static caching URL. This is useful if you only want certain query parameters to be persisted in your cache:

```php
'allowed_query_strings' => [
    'page',
],
```

**For example:** if you allow the `page` query parameter, and visit `/blog?page=2&utm_medium=social`, Statamic will serve/write the cached page for `/blog?page=2`.

You can also do the opposite, by specifying which query parameters should be excluded from the "normalized" static caching URL:

```php
'disallowed_query_strings' => [
    'utm_content', 'utm_medium', 'utm_source', 'utm_campaign',
],
```

**For example:** if you disallow the UTM query parameters, and visit `/blog?page=2&utm_medium=social`, Statamic will serve/write the cached page for `/blog?page=2`.

The `ignore_query_strings` option should be set to `false` in order for the `allowed_query_strings` & `disallowed_query_strings` to work.

## Multi-site

When using static caching alongside [multi-site](/multi-site), some additional configuration is needed.

### Paths

The `path` config option accepts an array, allowing you to define a different path for each site:

``` php
return [
    'strategies' => [
        'full' => [
            'driver' => 'file',
            'path' => [
               'english' => public_path('static') . '/domain.com/',
               'french' => public_path('static') . '/domain.fr/',
               'german' => public_path('static') . '/domain.de/',
            ],
        ],
    ],
];
```

For sites with subdirectory URLs rather than separate domains, you should ensure that all sites with the same domain have the same path.

For example: the `english` and `french` sites below are on the same domain, whereas `german` is on its own domain.

``` php
return [
    'strategies' => [
        'full' => [
            'driver' => 'file',
            'path' => [
               'english' => public_path('static') . '/domain.com/',
               'french' => public_path('static') . '/domain.com/',

               'german' => public_path('static') . '/domain.de/',
            ],
        ],
    ],
];
```

_**Note:** You only need to configure paths when you're using full-measure static caching._

### Rewrite rules

When you have sites across multiple domains, you will need to modify the rewrite rules on your server to include the domain name.

_**Note:** You only need to configure rewrite rules when you're using full-measure static caching._

#### Apache

You should update the rewrites in your `.htaccess` file to include `%{HTTP_HOST}`:

``` htaccess
RewriteCond %{DOCUMENT_ROOT}/static/%{HTTP_HOST}/%{REQUEST_URI}_%{QUERY_STRING}\.html -s
RewriteCond %{REQUEST_METHOD} GET
RewriteRule .* static/%{HTTP_HOST}/%{REQUEST_URI}_%{QUERY_STRING}\.html [L,T=text/html]
```

#### Nginx

You should update the `try_files` line inside the `@static` block:

``` nginx
location @static {
    try_files /static${uri}_$args.html $uri $uri/ /index.php?$args; # [tl! remove]
    try_files /static/${host}${uri}_$args.html $uri $uri/ /index.php?$args; # [tl! add]
}
```

The `${host}` argument should correspond to the domains set up in the path. This will be dependant on the server. If you're running different environments and need to use caching for them, you should define the paths using an ENV variable that corresponds to each server domain. The path can be configured in the `static_caching` config:

For example:

``` php
'strategies' => [
    'full' => [
        'driver' => 'file',
        'path' => public_path('static') . '/' .env('APP_DOMAIN'), // [tl! focus]
        'lock_hold_length' => 0,
        'warm_concurrency' => 10
    ],
],
```

and then on your server

```
# Production
APP_DOMAIN=domain1.com

# Dev
APP_DOMAIN=domain1.devserver.com
```

#### IIS

``` xml
<rule name="Static Caching" stopProcessing="true">
  <match url="^(.*)"  />
  <action type="Rewrite" url="/static/{SERVER_NAME}/{R:1}_{QUERY_STRING}.html"  />
</rule>
```

:::tip
`{SERVER_NAME}` is used here instead of `{HTTP_HOST}` because `{HTTP_HOST}` may include the port.
:::

### Invalidation rules

In the [invalidation rules array](#when-saving) explained above, the URLs are relative.

If you are using sites with multiple domains, you should define URLs in additional domains using absolute URLs. Relative URLs will assume the first site's domain.

```php
return [
    'invalidation' => [
        'rules' => [
            'collections' => [
                'blog' => [
                    'urls' => [
                        '/blog', // [tl! **]
                        'https://domaintwo.com/articles',  // [tl! **]
                    ]
                ],
            ],
        ],
    ],
];
```

:::tip
Rather than hardcoding the domains, you could use a config key or a variable.

```php
<?php
$two = config('statamic.sites.sites.two.url'); // [tl! **]

return [
    // ...
    'urls' => [
        '/blog',
        $two.'articles', // [tl! **]
    ]
```
:::

## Replacers

When a page is being statically cached on the first request, or loaded on subsequent requests, they are sent through "replacers".

Statamic includes two replacers out of the box. One will replace [CSRF tokens](#csrf-tokens), the other will handle [nocache](/tags/nocache) tag usages.

A replacer is a class that implements a `Statamic\StaticCaching\Replacer` interface. You will be passed responses to the appropriate methods where you can adjust them as necessary.

You can then enable your class by adding it to `config/statamic/static_caching.php`:

```php
'replacers' => [
    CsrfTokenReplacer::class,
    NoCacheReplacer::class,
    MyReplacer::class, // [tl!++]
]
```

### CSRF Tokens

When using half measure, CSRF tokens will be replaced without any caveats.

When using full measure, tokens will automatically be replaced in `<input>` and `<meta>` tags where their value/content is the token.

```
<meta name="csrf-token" content="{{ csrf_token }}" />
<input type="hidden" name="_token" value="{{ csrf_token }}" />
```

If you need to output a CSRF token in another place while using full measure, you'll need to use nocache tags.

```
<span>
{{ nocache }} {{# [tl!++] #}}
    {{ csrf_token }}
{{ /nocache }} {{# [tl!++] #}}
</span>
```

## Custom cache store

Static caching leverages [Laravel's application cache](https://laravel.com/docs/cache) to store mappings of the URLs to the filenames. To ensure proper invalidation of changes to your content, Statamic uses a cache store _outside_ of the default one. Otherwise, running the `php artisan cache:clear` command can lead invalidation to fail.

The cache store can be customized in `config/cache.php`.

```php
'static_cache' => [
    'driver' => 'file',
    'path' => storage_path('statamic/static-urls-cache'),
],
```

By default, running `php artisan cache:clear` won't clear Statamic's cache store. To do this, run `php please static:clear`.
