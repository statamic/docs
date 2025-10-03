---
id: 5e1dbeb6-b59d-4c6c-a3fa-950c4372acba
blueprint: tips
title: 'Zero Downtime Deployments'
template: page
categories:
  - development
  - troubleshooting
---
## Understanding the folder structure

Zero downtime deployment services like [Laravel Forge](https://forge.laravel.com/), [Envoyer](https://envoyer.io/) and [Deployer](https://deployer.org/) typically use a multiple-release directory structure and symlinks to handle deployments.

For example, with Laravel Forge:

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

Every deployment has its own timestamped release directory, with a fresh clone of the app. The `.env` file is stored at the top level, and shared between releases using symlinks.

After a successful deployment, the `current` folder is then symlinked to the latest release. This symlink swap is the secret sauce for zero downtime.

## Cache storage
Statamic's content management heavily relies on caching, and sometimes it's necessary for the [Stache](/stache) to store absolute file paths in your app's cache. This can lead to deployment errors when users are hitting your frontend, since each release [exists in a separate timestamped folder](#understanding-the-folder-structure).

The solution is simple. Just as you should never share a cache between different websites, you should never share a cache between your deployed releases.

### How to avoid sharing file cache

To avoid sharing the file cache between your deployment releases, create a `cache` folder at the top level in your app, bypassing the default `storage` folder, as it _is_ shared between releases. Configure your app to use a custom cache store location by changing `stores.file.path` in `config/cache.php`:

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

## Git Automation

If you plan to use Statamic's [Git Automation](/git-automation) feature alongside zero downtime deployments, you may need to tweak your deployment settings to enable git commits and pushes from each release folder.

### Setting up a Git remote

:::tip
Unlike other services, Laravel Forge will actually keep the `.git` folder around in each release, meaning you can skip this step.
:::

Most zero downtime deployment services, like [Envoyer](https://envoyer.io/) and [Deployer](https://deployer.org/) create releases _without_ a `.git` folder, which Statamic needs to commit and push content back to your repository.

You can work around this by setting up a Git object right after the `Clone New Release` step of your deployment process:

```bash
git init
git remote add origin git@github.com:your/remote-repository.git
git fetch
git branch --track main origin/main
git reset HEAD
```

Be sure to modify the above remote to point to your remote repository, along with the branch you wish to track.

### Preventing circular deployments

If you plan on enabling automatic deployment when commits are pushed to your repository, you may wish to selectively disable deployments when Statamic pushes commits back to your repository.

To do this, you will first need to append `[BOT]` to Statamic's commit messages [as documented here](/git-automation#customizing-commits). Once this is done, you can add a step to your deployment process to cancel the deployment when the commit message contains `[BOT]`.

```php
if [[ $FORGE_DEPLOY_MESSAGE =~ "[BOT]" ]]; then
    echo "AUTO-COMMITTED ON PRODUCTION. NOTHING TO DEPLOY."
    exit 0
fi
```

### Ensuring proper deployment hook order

When adding these steps to your deployment process, you should be mindful of the order in which they happen. Here's the order we recommend:

* Cancel deployments when commit message contains `[BOT]`
* Create release
* Init Git repository & add Git remote (if necessary)
* The rest of your deployment script...

:::tip
If you're using [Static Caching](/static-caching), make sure you warm the cache _after_ updating the current release, otherwise you'll be warming the wrong cache.
:::

### Committing form submissions

If you plan on committing form submissions, you will need to store them outside the shared `storage` directory. 

To customize where form submissions are stored, add a `form-submissions` array to your `config/statamic/stache.php` config file:

```php
'stores' => [
    'form-submissions' => [ // [tl! ++]
        'class' => \Statamic\Stache\Stores\SubmissionsStore::class, // [tl! ++]
        'directory' => base_path('forms'), // [tl! ++]
    ], // [tl! ++]
],
```

After doing this, you will also need to update the tracked path for your submissions in `config/statamic/git.php`:

```php
'paths' => [
    base_path('content'),
    base_path('users'),
    resource_path('blueprints'),
    resource_path('fieldsets'),
    resource_path('forms'),
    resource_path('users'),
    resource_path('preferences.yaml'),
    resource_path('sites.yaml'),
    storage_path('forms'), // [tl! focus --]
    base_path('forms'), // [tl! focus ++]
    public_path('assets'),
],
```
