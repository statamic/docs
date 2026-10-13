---
id: 5e1dbeb6-b59d-4c6c-a3fa-950c4372acba
blueprint: tips
title: 'Zero Downtime Deployments'
intro: 'How zero-downtime deploy tools structure releases, and how to set up Statamic so the Stache cache and Git Automation work correctly with them.'
template: page
categories:
  - development
  - troubleshooting
---
## Understanding the folder structure

Zero downtime deployment services like [Laravel Forge](https://forge.laravel.com/), [Envoyer](https://envoyer.io/), [Ploi](https://ploi.io/) and [Deployer](https://deployer.org/) typically use a multiple-release directory structure and symlinks to handle deployments.

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

### Ensure update scripts are run 

Since each new deployment is a fresh installation of the application, update scripts can be missed. 
To ensure update scripts are run, add a step to your deployment pipeline that makes a backup of the `composer.lock` file.
``` shell
# Backup composer lock file to ensure update scripts are run
cp composer.lock storage/statamic/updater/composer.lock.bak
```

## Cache storage

Statamic's content management heavily relies on caching, and sometimes it's necessary for the [Stache](/stache) to store absolute file paths in your app's cache. This can lead to deployment errors when users are hitting your frontend, since each release [exists in a separate timestamped folder](#understanding-the-folder-structure).

The solution is simple. Just as you should never share a cache between different websites, you should never share a cache between your deployed releases.

### How to avoid sharing file cache

There are three ways to avoid sharing a file cache between your deployment releases:

1. Some services, like Laravel Forge, may allow you to configure the "shared paths" between deployments. If your application allows for it, you could remove the `storage` directory from your site's shared paths, ensuring each release has its own `storage` folder.

2. Another option is to create a `cache` folder at the top level of your app, bypassing the shared `storage` folder. Configure your app to use a custom cache store location by changing `stores.file.path` in `config/cache.php`:

    ```php
    'stores' => [
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'), // [tl! --]
            'path' => base_path('cache'), // [tl! ++]
        ],
    ],
    ```

    This affects all file cache usage (rate limits, locks, queue locks, etc.), not just the Stache.

3. For a more targeted variant, give the Stache its own dedicated cache store. Laravel's default cache stays put. In `config/cache.php`, add a new store:

    ```php
    'stores' => [
        'stache' => [ // [tl! ++]
            'driver' => 'file', // [tl! ++]
            'path' => base_path('stache'), // [tl! ++]
            'lock_path' => base_path('stache'), // [tl! ++]
        ], // [tl! ++]
    ],
    ```

    Then in `config/statamic/stache.php`, point the Stache at the new store:

    ```php
    'cache_store' => 'stache', // [tl! ++]
    ```

### How to avoid sharing Redis cache

There are two ways to avoid sharing a Redis cache between your deployment releases:

1. Set a cache prefix unique to each release on your filesystem by adding a `redis.cache.options.prefix` in `config/database.php`:

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

    This affects all Redis cache usage (rate limits, locks, queue locks, etc.), not just the Stache.

2. For a more targeted variant, give the Stache its own dedicated Redis cache store. Laravel's default Redis cache stays shared between releases, which is what you want for things like rate limits and queue locks.

    In `config/database.php`, add a new Redis connection with a per-release prefix:

    ```php
    'redis' => [
        // ...
        'stache' => [ // [tl! ++]
            'url' => env('REDIS_URL'), // [tl! ++]
            'host' => env('REDIS_HOST', '127.0.0.1'), // [tl! ++]
            'password' => env('REDIS_PASSWORD'), // [tl! ++]
            'port' => env('REDIS_PORT', '6379'), // [tl! ++]
            'database' => env('REDIS_CACHE_DB', '1'), // [tl! ++]
            'options' => [ // [tl! ++]
                'prefix' => basename(base_path()).'_stache_', // [tl! ++]
            ], // [tl! ++]
        ], // [tl! ++]
    ],
    ```

    In `config/cache.php`, add a cache store using that connection:

    ```php
    'stores' => [
        'stache' => [ // [tl! ++]
            'driver' => 'redis', // [tl! ++]
            'connection' => 'stache', // [tl! ++]
        ], // [tl! ++]
    ],
    ```

    Then in `config/statamic/stache.php`, point the Stache at the new store:

    ```php
    'cache_store' => 'stache', // [tl! ++]
    ```

    :::tip
    The `stache` connection above shares Redis database `1` with the default `cache` connection. Key prefixes keep their entries separate during normal use, but `php artisan cache:clear` wipes both. Point the `stache` connection at a different database (e.g. `'database' => env('REDIS_STACHE_DB', '2')`) for complete isolation, mirroring the file cache option above where the two stores naturally live in separate directories.
    :::

## Git Automation

If you plan to use Statamic's [Git Automation](/git-automation) feature alongside zero downtime deployments, you'll need to set up a dedicated git clone for Statamic's content writes so they survive the symlink swap. See [Why this setup is needed](#why-this-setup-is-needed) at the end of this section for the full picture.

:::tip
Examples below use Laravel Forge syntax. The same concepts apply to Envoyer, Ploi, Deployer, or custom scripts; you'll need to adapt the platform-specific syntax.
:::

### Prerequisites

Set a global git identity on the server. Autostash and rebase in [Updating your deploy script](#updating-your-deploy-script) need it:

```bash
git config --global user.name "$(hostname)"
git config --global user.email "$(whoami)@$(hostname).local"
```

### Setting up a Git remote

Create a new `statamic` directory at the root of your site with a [sparse-checkout](https://git-scm.com/docs/git-sparse-checkout) clone inside it. The clone lives outside any release directory, giving Statamic's Git Automation a dedicated working tree where content writes can be committed and pushed reliably.

The sparse-checkout list below covers the paths Statamic tracks by default. We'll wire `config/statamic/git.php` to point at this clone in [Configuring git paths](#configuring-git-paths) further down. Be sure to replace `your-site`, `your-org/your-repo`, and `your-branch` with your values:

```bash
cd your-site
mkdir -p statamic && cd $_
git init
git remote add origin git@github.com:your-org/your-repo.git
git config core.sparseCheckout true
cat > .git/info/sparse-checkout <<'EOF'
content/
users/
resources/addons/
resources/blueprints/
resources/fieldsets/
resources/forms/
resources/users/
resources/preferences.yaml
resources/sites.yaml
public/assets/
EOF
git fetch origin your-branch
git checkout your-branch
```

:::tip
Form submissions are handled separately. See [Committing form submissions](#committing-form-submissions).
:::

### Adding shared paths

In your deployment tool's shared paths configuration, add an entry for each path in the sparse-checkout list from [Setting up a Git remote](#setting-up-a-git-remote) above.

| From                                  | To                           |
| ------------------------------------- | ---------------------------- |
| `statamic/content`                    | `content`                    |
| `statamic/users`                      | `users`                      |
| `statamic/resources/addons`           | `resources/addons`           |
| `statamic/resources/blueprints`       | `resources/blueprints`       |
| `statamic/resources/fieldsets`        | `resources/fieldsets`        |
| `statamic/resources/forms`            | `resources/forms`            |
| `statamic/resources/users`            | `resources/users`            |
| `statamic/resources/preferences.yaml` | `resources/preferences.yaml` |
| `statamic/resources/sites.yaml`       | `resources/sites.yaml`       |
| `statamic/public/assets`              | `public/assets`              |

### Configuring git paths

In `config/statamic/git.php`, wrap every tracked path in an environment variable so the production paths stay configurable through `.env`. The defaults fall back to the standard Statamic locations when no variable is set.

```php
'paths' => [
    env('STATAMIC_GIT_CONTENT_PATH', base_path('content')),
    env('STATAMIC_GIT_USERS_PATH', base_path('users')),
    env('STATAMIC_GIT_ADDONS_PATH', resource_path('addons')),
    env('STATAMIC_GIT_BLUEPRINTS_PATH', resource_path('blueprints')),
    env('STATAMIC_GIT_FIELDSETS_PATH', resource_path('fieldsets')),
    env('STATAMIC_GIT_FORMS_PATH', resource_path('forms')),
    env('STATAMIC_GIT_RESOURCE_USERS_PATH', resource_path('users')),
    env('STATAMIC_GIT_PREFERENCES_PATH', resource_path('preferences.yaml')),
    env('STATAMIC_GIT_SITES_PATH', resource_path('sites.yaml')),
    env('STATAMIC_GIT_ASSETS_PATH', public_path('assets')),
],
```

Then add the corresponding values to the site's `.env`, pointing each one at its path inside the `statamic` directory you created above. Be sure to replace `forge/your-site` with your site's path:

```
STATAMIC_GIT_CONTENT_PATH=/home/forge/your-site/statamic/content
STATAMIC_GIT_USERS_PATH=/home/forge/your-site/statamic/users
STATAMIC_GIT_ADDONS_PATH=/home/forge/your-site/statamic/resources/addons
STATAMIC_GIT_BLUEPRINTS_PATH=/home/forge/your-site/statamic/resources/blueprints
STATAMIC_GIT_FIELDSETS_PATH=/home/forge/your-site/statamic/resources/fieldsets
STATAMIC_GIT_FORMS_PATH=/home/forge/your-site/statamic/resources/forms
STATAMIC_GIT_RESOURCE_USERS_PATH=/home/forge/your-site/statamic/resources/users
STATAMIC_GIT_PREFERENCES_PATH=/home/forge/your-site/statamic/resources/preferences.yaml
STATAMIC_GIT_SITES_PATH=/home/forge/your-site/statamic/resources/sites.yaml
STATAMIC_GIT_ASSETS_PATH=/home/forge/your-site/statamic/public/assets
```

### Updating your deploy script

The deploy script below is an example for Laravel Forge with the new lines highlighted. Adapt the `$FORGE_*` variables and macros to your platform's equivalents.

```bash
$CREATE_RELEASE()

cd $FORGE_RELEASE_DIRECTORY

$FORGE_COMPOSER install --no-dev --no-interaction --prefer-dist --optimize-autoloader
$FORGE_PHP artisan optimize
$FORGE_PHP artisan storage:link

cd $FORGE_SITE_ROOT/statamic # [tl! ++]
git pull --rebase --autostash origin $FORGE_SITE_BRANCH # [tl! ++]
cd $FORGE_RELEASE_DIRECTORY # [tl! ++]

$FORGE_PHP please stache:warm
$FORGE_PHP please search:update --all

npm ci || npm install
npm run build

$ACTIVATE_RELEASE()

$RESTART_QUEUES()
```

The pull runs before `stache:warm` so the Stache is warmed against the final content state. It brings in any content commits pushed from elsewhere, like edits made in a developer's local environment.

[`--autostash`](https://git-scm.com/docs/git-rebase#Documentation/git-rebase.txt---autostash) makes sure any in-flight writes in the Statamic clone, like a Control Panel edit Statamic's queue hasn't committed yet, survive the pull.

:::tip
If you're using [Static Caching](/static-caching), make sure you warm the cache _after_ activating the current release, otherwise you'll be warming the wrong cache.
:::

### Committing form submissions

If you plan on committing form submissions, you will need to store them outside the shared `storage` directory.

First, customize where form submissions are stored by adding a `form-submissions` array to your `config/statamic/stache.php`:

```php
'stores' => [
    'form-submissions' => [ // [tl! ++]
        'class' => \Statamic\Stache\Stores\SubmissionsStore::class, // [tl! ++]
        'directory' => base_path('forms'), // [tl! ++]
    ], // [tl! ++]
],
```

Then track the new path by adding an env-wrapped entry to `config/statamic/git.php`:

```php
'paths' => [
    env('STATAMIC_GIT_SUBMISSIONS_PATH', base_path('forms')), // [tl! ++]
],
```

And the matching value to the site's `.env`:

```
STATAMIC_GIT_SUBMISSIONS_PATH=/home/forge/your-site/statamic/forms
```

Finally, populate `forms/` in the Statamic clone and add a matching shared path. See steps 1 and 2 of [Adding paths later](#adding-paths-later).

### Adding paths later

To track and commit additional paths after the initial setup, follow the same order as the main flow:

1. **[Populate the path in the Statamic clone](#setting-up-a-git-remote):**

    ```bash
    cd /home/forge/your-site/statamic
    git sparse-checkout add <path>/
    ```

2. **[Add a new shared path](#adding-shared-paths)**.

3. **[Configure the git path](#configuring-git-paths)**.

### Preventing circular deployments

If you plan on enabling automatic deployment when commits are pushed to your repository, you may wish to selectively disable deployments when Statamic pushes commits back to your repository.

To do this, you will first need to append `[BOT]` to Statamic's commit messages [as documented here](/git-automation#customizing-commits). Once this is done, add the following at the very top of your deploy script, before the release is created, so the check happens before any deployment work is done:

```bash
if [[ $FORGE_DEPLOY_MESSAGE =~ "[BOT]" ]]; then
    echo "AUTO-COMMITTED ON PRODUCTION. NOTHING TO DEPLOY."
    exit 0
fi
```

### Why this setup is needed

Statamic's Git Automation tracks paths defined in [config/statamic/git.php](#configuring-git-paths) using helpers like `base_path('content')` and `resource_path('forms')`, which resolve to whichever release the running process is in. Without intervention, this creates two failure modes during zero-downtime deploys.

#### Silent skipped commits

A Control Panel edit during a deploy lands in the old release's content directory. After the symlink swap and queue restart, the queued commit job runs from the _new_ release, reads its path config against the new release's `base_path()`, finds a clean working tree, and exits without committing. No error is raised. When the old release is later cleaned up, the write is gone.

#### Push rejections

Each release ships with its own `.git/`. If something else pushes to origin (a developer pushing code, a second server, an overlapping worker from a previous release), the release's local history can fall behind origin and the push gets rejected:

```
error: failed to push some refs to '…'. Updates were rejected because the remote contains work that you do not have locally.
```

[Shared paths](#adding-shared-paths) fix the first by routing writes to a persistent location outside any release, so Statamic's commits always see them. The dedicated [Statamic clone](#setting-up-a-git-remote) fixes the second by giving Statamic a single `.git/` that persists across deploys instead of being a fresh clone every time. The [deploy script's `git pull`](#updating-your-deploy-script) resyncs it with any external commits at deploy time.
