---
title: 'Static Caching'
template: page
blueprint: page
intro: |
    Nothing loads faster than static pages. Instead of rendering pages dynamically on demand, Statamic can cache static pages and pass routing to Apache or Nginx with reverse proxying.
id: ffa24da8-3fee-4fc9-a81b-fcae8917bd74
---
## Important Preface

Certain features — such as forms with server-side validation, page protection, or content randomization — may not work with static page caching. (You may want to check out the [nocache tag](/tags/nocache) though.) As long as you understand that, you can leverage static caching for maximum performance.

Whatever is on the page the first time it's visited is what will be cached for all users. For example, if you're using page protection and a user who has access visits the page, it'll be accessible to everyone.

:::tip
You can **alternatively** use the [static site generator](https://github.com/statamic/ssg) to pre-generate and deploy **fully static HTML sites**.
:::

## Caching Strategies

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

## Application Driver

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

## File Driver

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

## Server Rewrite Rules

You will need to configure its rewrite rules when using full measure caching. Here are the rules for each type of server.

### Apache

On Apache servers, you can define rewrite rules inside an `.htaccess` file:

``` htaccess
RewriteCond %{DOCUMENT_ROOT}/static/%{REQUEST_URI}_%{QUERY_STRING}\.html -s
RewriteCond %{REQUEST_METHOD} GET
RewriteRule .* static/%{REQUEST_URI}_%{QUERY_STRING}\.html [L,T=text/html]
```

### Nginx

On Nginx servers, you will need to edit your `.conf` files. They are not located within your project, and may be in a slighly different place depending on your server setup.

Some applications like [Laravel Forge](https://forge.laravel.com) may let you edit your `nginx.conf` from within the UI.

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

## Warming the Static Cache

You can get your app to automatically generate the public views for your entries and add them to the Static Cache, making first times loads much faster. To do this run:

```
php please static:warm
```

This command can take some time to process so if you have a lot of entries you might want to use the `--queue` flag.

Passing `--insecure` to the command allows you to skip SSL verification. This can come in handy when running the site behind a reverse proxy or when using self-signed certificates, for example.

Adding the `--user` and `--password` flags, you can run the command behind [HTTP Basic Authentication](https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#basic_authentication_scheme). Useful when your site is secured with a simple username and password, like on a staging or development server. Otherwise, you might end up with a `401 Unauthorized` error running the command.

Depending on your site's setup, it's a good idea to add this command to your deployment script on Forge or whatever deployment tool or pipeline you use.

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
        'class' => \App\StaticCaching\CustomExcluder::class, // [tl! add]

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

## Invalidation

A statically cached page will be served until it is invalidated. You have a several options for how to invalidate your cache.

### Time Limit

When using the application driver, you may specify the `expiry` time in minutes in the `static_caching.php` config file. After this length of time, the next request will be served fresh. By leaving the expiry setting `null`, it will never expire, except when you manually run `php artisan cache:clear`.

**The expiry option is not available when using the file driver.** The generated HTML files will be served before PHP ever gets hit, and there's just nothing we can do about that.

### When Saving

When saving content, the corresponding item’s URL will be flushed from the static cache automatically.

You may also set specific rules for invalidating other pages when content is saved. For example:

``` php
return [
    'class' => null,
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
    'class' => null,
    'invalidation' => [
        'rules' => 'all',
    ]
];
```

### Custom Invalidator Class

You can also specify a custom invalidator class to **programatically determine which URLs should be invalidated**. To achieve that, override or extend [the default invalidator class](https://github.com/statamic/cms/blob/01f8dfd1cbe304be1848d2e4be167a0c49727170/src/StaticCaching/DefaultInvalidator.php).

```php
'invalidation' => [
    'class' => MyCustomInvalidator::class,
]
```

Note that the container binding for the default invalidator won't be used now, so you'll need to provide your own. For example:

```php
$this->app->bind(CustomInvalidator::class, function ($app) {
    return new CustomInvalidator(
        $app[Cacher::class],
        $app['config']['statamic.static_caching.invalidation.rules']
    );
});
```

In your class you can then define the logic that decides how URLs should get invalidated.

```php
class MyCustomInvalidator extends DefaultInvalidator
{
    public function invalidate($item)
    {
        // flushes everything by setting the invalidation rules to 'all'
        if ($this->rules === 'all') {
            return $this->cacher->flush();
        }

        // invalidates entries from the 'events' collection, for example
        if ($item instanceof Entry) {
            if ($item->collection() == 'events') {
                // etc...
            }
        }

        // flushes only the URLs you define in the config
        if ($urls) {
            $this->cacher->invalidateUrls($urls);
        }

        if ($wantToRunDefaultLogic) {
            parent::invalidate($item);
        }
    }
}
```

### By Force

To clear the static file cache you can run `php please static:clear` (and/or delete the appropriate static file locations).

## File Locations

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


## Multi-Site

When using [multi-site](/multi-site), the path can accept an array of sites to define separate urls and domains, if needed.

``` php
return [

    'strategies' => [
        'full' => [
            'driver' => 'file',
            'path' => [
               'default'    => public_path('static') . '/domain1.com/',
               'default_fr' => public_path('static') . '/domain1.com/',
               'other_site' => public_path('static') . '/domain2.com/',
            ]
        ]
    ]
];
```

:::tip
Your static caching paths should be organized at the top level domain level. You'll notice 'default' and 'default_fr' in the example use the same domain. The subfolders will be organized based on the urls defined in your sites config.
:::

### Rewrite Rules

This multi-site example needs modified rewrite rules.

#### Apache

``` htaccess
RewriteCond %{DOCUMENT_ROOT}/static/%{HTTP_HOST}/%{REQUEST_URI}_%{QUERY_STRING}\.html -s
RewriteCond %{REQUEST_METHOD} GET
RewriteRule .* static/%{HTTP_HOST}/%{REQUEST_URI}_%{QUERY_STRING}\.html [L,T=text/html]
```

#### Nginx

``` nginx
location / {
  try_files /static/${host}${uri}_${args}.html $uri /index.php?$args;
}
```

The `${host}` argument should correspond to the domains set up in the path. This will be dependant on the server. If you're running different environments and need to use caching for them, you should define the paths using an ENV variable that corresponds to each server domain. The path can be configured in the `static_caching` config:

For example:

``` php
'strategies' => [

    'full' => [
        'driver' => 'file',
        'path' => public_path('static') . '/' .env('APP_DOMAIN'), // [tl! highlight:0]
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

### Invalidation Rules

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

A replacer is a class that implements a `Statamic\StaticCaching\NoCache\Replacer` interface. You will be passed responses to the appropriate methods where you can adjust them as necessary.

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
<input type="hidden" value="{{ csrf_token }}" />
```

If you need to output a CSRF token in another place while using full measure, you'll need to use nocache tags.

```
<span>
{{ nocache }} {{# [tl!++] #}}
    {{ csrf_token }}
{{ /nocache }} {{# [tl!++] #}}
</span>
```

## Custom Cache Store

Static Caching leverages [Laravel's application cache](https://laravel.com/docs/cache) to store mappings of the URLs to the filenames. To ensure proper invalidation of changes to your content, Statamic uses a cache store _outside_ of the default one. Otherwise, running the `artisan cache:clear` command can lead invalidation to fail.

The cache store can be customized in `config/cache.php`.

```php
'static_cache' => [
    'driver' => 'file',
    'path' => storage_path('statamic/static-urls-cache'),
],
```

By default, running `artisan cache:clear` won't clear Statamic's cache store. To do this, run `php please static:clear`.
