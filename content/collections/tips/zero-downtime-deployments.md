---
id: 5e1dbeb6-b59d-4c6c-a3fa-950c4372acba
blueprint: tips
title: 'Zero downtime deployments'
template: page
categories:
  - development
  - troubleshooting
---
## Understanding zero downtime deployment file structure

Services like [Envoyer](https://envoyer.io/), [Deployer](https://deployer.org/), etc. use a multiple-release directory structure with symlinking to make zero downtime deployments work. For example:

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

After a successful deployment, the `current` folder is then symlinked to the latest release. The swapping of this symlink is what technically allows for zero downtime.

## Cache storage

Statamic's content management heavily relies on caching, and sometimes it's necessary for the [Stache](/stache) to store absolute file paths in your app's cache. This can lead to deployment errors when while users are hitting your frontend, since each release [exists in a separate timestamped folder](#understanding-zero-downtime-deployment-file-structure).

The solution to this is pretty simple. Just like you would never share a cache between different websites, you should also avoid sharing a cache between your deployed releases.

### How to avoid sharing file cache

To avoid sharing file based cache between your deployment releases, we recommend creating a cache folder at the top level in your app. The key here is to avoid the `storage` folder, as it is shared between releases. You can configure your app to use a custom cache store location here in `config/cache.php`:

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

To avoid sharing Redis cache between your deployment releases, we recommend setting a cache prefix unique to each release on your filesystem. This can be configured here in `config/cache.php`:

```php
'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_cache'), // [tl! --]
'prefix' => env('CACHE_PREFIX', 'release_'.basename(base_path()).'_cache'), // [tl! ++]
```

:::tip
You may also want to `php artisan cache:clear` after each deployment, to ensure you don't bloat your Redis cache with old release data over time.
:::
