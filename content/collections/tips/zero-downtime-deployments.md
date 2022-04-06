---
id: 5e1dbeb6-b59d-4c6c-a3fa-950c4372acba
blueprint: tips
title: 'Zero Downtime Deployments'
template: page
categories:
  - development
  - troubleshooting
---
## Understanding zero downtime deployment file structure

Zero downtime services like [Envoyer](https://envoyer.io/) and [Deployer](https://deployer.org/) use a multiple-release directory structure and symlinks to handle deployments. For example:

### The Envoyer file structure

``` files theme:serendipity-light
.env
storage
current -> symlinked to latest release
releases
  20220215112950
    .env -> symlinked to top level shared .env
    storage -> symlinked to top level shared storage
    app
    routes
    etc
  20220322153109
  20220323180225
  20220322153109
```

Each deployment creates a timestamped release folder, with a fresh clone of the app. The `.env` file and the `storage` folder are stored at the top level, and shared between releases using symlinks.

After a successful deployment, the `current` folder is then symlinked to the latest release. This symlink swap is the secret sauce for zero downtime.

## Cache storage

Statamic's content management heavily relies on caching, and sometimes it's necessary for the [Stache](/stache) to store absolute file paths in your app's cache. This can lead to deployment errors when while users are hitting your frontend, since each release [exists in a separate timestamped folder](#understanding-zero-downtime-deployment-file-structure).

The solution is simple. Just as you should never share a cache between different websites, you should never share a cache between your deployed releases.

### How to avoid sharing file cache

To avoid sharing file based cache between your deployment releases, create a cache folder at the top level in your app, bypassing the default `storage` folder, as it _is_ shared between releases. Configure your app to use a custom cache store location by changing `stores.file.path` in `config/cache.php`:

```php
'stores' => [
    'file' => [
        'driver' => 'file',
        'path' => storage_path('framework/cache/data'), // [tl! --]
        'path' => base_path('cache'), // [tl! ++]
    ],
],
```

### How to avoid sharing Redis cache

To avoid sharing a Redis cache between your deployment releases, we recommend setting a cache prefix unique to each release on your filesystem. This can be configured by adding a `redis.cache.options.prefix` in `config/database.php`:

```php
'redis' => [
    'cache' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_CACHE_DB', '1'),
        'options' => [ // [tl! ++]
            'prefix' => basename(base_path()).'_', // [tl! ++]
        ], // [tl! ++]
    ],
],
```

:::tip
Run `php artisan cache:clear` after each deployment to ensure you don't bloat your Redis cache with old release data over time.
:::
