---
id: d0e99506-d01d-484c-884f-46dfc4dcf4c5
blueprint: page
title: 'Contribution Guide'
intro: 'A guide on how to contribute to the `statamic/cms` repo'
---

## Fork the repo
First, you need to create a fork of the repo. A fork is a copy of the repo where you can make changes before sending them back with a request to be merged into the original repo.

Head to the [cms repo][cms-repo] and click the "Fork" button at the top right.

## Clone it
Once you have a fork, you can clone it on your local machine with git. It can go anywhere - you probably already have a folder where your projects live. Most people use `~/Sites/` or ~/Code`.

```shell
cd Code # [tl! **]
git clone https://github.com/your-username/cms.git # [tl! **]
Cloning into 'cms'...
remote: Enumerating objects: 86396, done.
remote: Counting objects: 100% (3025/3025), done.
remote: Compressing objects: 100% (1917/1917), done.
remote: Total 86396 (delta 1674), reused 2078 (delta 1085), pack-reused 83371
Receiving objects: 100% (86396/86396), 33.39 MiB | 5.76 MiB/s, done.
Resolving deltas: 100% (67201/67201), done.
```

## Create a sandbox project
The `cms` repo is just the Laravel package — it can't run on its own. It needs to be installed into a Laravel app.

The easiest way to set this up is to install a Starter Kit. In a separate folder, create your site:

```shell
cd sites # [tl! **]
statamic new sandbox # [tl! **]
Creating a statamic/statamic project at ./sandbox
[✔] Statamic has been successfully installed into the sandbox directory.
Build something rad!
```

## Link your fork to the sandbox
At this point, your sandbox app is going to be using the "real" version of Statamic. You'll need to tell it to use your local fork.

In your app's `composer.json`, add a `repositories` array with a "path" repository pointing to where you cloned your fork earlier:

```json
{
    "name": "statamic/statamic",
    "description": "Statamic",
    "keywords": ["statamic", "cms", "flat file", "laravel"],
    "type": "project",
    "require": {  // [tl! collapse:start]
        "php": "^7.3 || ^8.0",
        "fideloper/proxy": "^4.2",
        "fruitcake/laravel-cors": "^2.0",
        "guzzlehttp/guzzle": "^7.0.1",
        "laravel/framework": "^8.0",
        "laravel/tinker": "^2.0",
        "statamic/cms": "3.2.*"
    },  // [tl! collapse:end]
    "require-dev": {  // [tl! collapse:start]
        "barryvdh/laravel-debugbar": "^3.5",
        "facade/ignition": "^2.3.6",
        "fakerphp/faker": "^1.9.1",
        "mockery/mockery": "^1.3.1",
        "nunomaduro/collision": "^5.0",
        "phpunit/phpunit": "^9.3"
    },  // [tl! collapse:end]
    "config": {  // [tl! collapse:start]
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true
    },  // [tl! collapse:end]
    "extra": {  // [tl! collapse:start]
        "laravel": {
            "dont-discover": []
        }
    },  // [tl! collapse:end]
    "autoload": {  // [tl! collapse:start]
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },  // [tl! collapse:end]
    "autoload-dev": {   // [tl! collapse:start]
        "psr-4": {
            "Tests\\": "tests/"
        }
    },  // [tl! collapse:end]
    "minimum-stability": "dev",
    "prefer-stable": true,
    "scripts": {   // [tl! collapse:start]
        "pre-update-cmd": [
            "Statamic\\Console\\Composer\\Scripts::preUpdateCmd"
        ],
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi",
            "@php artisan statamic:install --ansi"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ]
    },  // [tl! collapse:end]
    "repositories": [ // [tl! focus:start]
        {
            "type": "path",
            "url": "/path/to/cms"
        }
    ] // [tl! focus:end]
}
```

Next, require the branch of `cms` you checked out:

```shell
composer require "statamic/cms 3.2.x-dev"
```

(We'll go into more detail in a moment on what constraint should be used there.)

In the output, you should see it symlinks the `cms` directory to your fork:

```shell
./composer.json has been updated
Running composer update statamic/cms
> Statamic\Console\Composer\Scripts::preUpdateCmd
Loading composer repositories with package information
Updating dependencies
Lock file operations: 0 installs, 1 update, 0 removals
  - Upgrading statamic/cms (v3.2.17 => 3.2.x-dev) # [tl! focus]
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 0 installs, 1 update, 0 removals
  - Removing statamic/cms (v3.2.17)
  - Installing statamic/cms (3.2.x-dev): Symlinking from /path/to/cms  # [tl! focus]
  - Downloading statamic/cms (dist)
    Failed to download
Generating optimized autoload files
composer/package-versions-deprecated: Generating version class...
composer/package-versions-deprecated: ...done generating version class
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi
Discovered Package: ajthinking/archetype
Discovered Package: barryvdh/laravel-debugbar
Discovered Package: facade/ignition
Discovered Package: fideloper/proxy
Discovered Package: fruitcake/laravel-cors
Discovered Package: intervention/image
Discovered Package: laravel/tinker
Discovered Package: nesbot/carbon
Discovered Package: nunomaduro/collision
Discovered Package: rebing/graphql-laravel
Discovered Package: statamic/cms
Discovered Package: wilderborn/partyline
Package manifest generated successfully.
> @php artisan statamic:install --ansi
Addon manifest generated successfully.
Copied Directory [/users/jason/code/cms/resources/users] To [/resources/users]
Publishing complete.
Copied Directory [/users/jason/code/cms/resources/dist] To [/public/vendor/statamic/cp]
Publishing complete.
Compiled views cleared!
Application cache cleared!
101 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
```

You can confirm it by checking the path to the package:

```shell
composer show statamic/cms --path # [tl! focus]
statamic/cms /path/to/cms
```

## Use an appropriate branch

Be sure to work on a new, dedicated branch for your Pull Request. Among other things, it'll make it easier for the Statamic team to push minor changes if necessary (like fixing typos, code style, tweaks, and so on). We request that you add "feature" or "fix" in the branch name so it's easier to understand the intent of your PR.

```shell
git checkout -b feature/new-thing
git checkout -b fix/issue-9999
```

:::warning Psst!
When requiring the `cms` package, it's important to require the appropriate constraint. If you don't use the right one, Composer may decide to use the _real_ `cms` package, and you'll be left wondering why your code changes aren't appearing.
:::

If the branch is numeric then you need to require `BRANCH.x-dev` (e.g. a branch named `3.2` should use a constraint of `3.2.x-dev`).

Otherwise, you'll need to use `dev-BRANCH` (e.g. a branch named `feature/mybranch` should use a constraint of `dev-feature/mybranch`).

:::tip
Once you've done the initial symlink, you can change `cms` branches freely. However once again, be aware if you do a `composer update` or `require`, you may end up with a live version of `cms`.
:::

## Dealing with assets
If your contribution involves Control Panel assets - Stylesheets, JavaScript, or Vue components - you'll need to compile them and have them used by your sandbox app. You can do this with another symlink.

In your sandbox, delete the `public/vendor/statamic/cp` directory, which should have been created when you initially created the site.

Compile the assets within the `cms` repo.

```shell
cd cms
npm ci
npm run dev  # or npm run watch
```

The assets will be compiled into `cms/resources/dist`. You can now symlink them into your sandbox:

```shell
cd sandbox
ln -s /path/to/cms/resources/dist public/vendor/statamic/cp
```

:::tip
**Do not attempt to commit any compiled code.** They should already be gitignored, and will be automatically recompiled at release time.
:::


## Commit code
Now you're ready to actually write code.

If you're writing tests, you can run the test suite inside the `cms` repo.

If you want to manually test or use the package, you can do it in through your sandbox. Any changes you make to the code in your `cms` repo will be reflected in your sandbox app which you can see in the browser.

Once you're done, you should push your branch to Github.

```shell
git push --set-upstream origin HEAD # [tl! **]
Enumerating objects: 5, done.
Counting objects: 100% (5/5), done.
Delta compression using up to 8 threads
Compressing objects: 100% (3/3), done.
Writing objects: 100% (3/3), 309 bytes | 309.00 KiB/s, done.
Total 3 (delta 2), reused 0 (delta 0), pack-reused 0
remote: Resolving deltas: 100% (2/2), completed with 2 local objects.
remote:
remote: Create a pull request for 'feature/new-thing' on GitHub by visiting:  # [tl! **]
remote:      https://github.com/jasonvarga/cms/pull/new/feature/new-thing # [tl! **]
remote:
To https://github.com/jasonvarga/cms.git
 * [new branch]          HEAD -> feature/new-thing
Branch 'feature/new-thing' set up to track remote branch 'feature/new-thing' from 'origin'.
```

## Create the Pull Request
In the output from pushing your branch above, it'll give you a link to create the pull request. If you missed it, no problem. Just head over to `statamic/cms` and you should see a banner waiting for you.

![](/img/guides/contribution-guide/pull-request-banner.png)

Click through there and you'll be taken to a form where you can describe what's being contributed.

![](/img/guides/contribution-guide/pull-request-form.png)

Please be as thorough as possible. Explain what's being added, what it fixes, list any relevant issues or discussions, and explain how we can test out the changes.

## Cleaning Up
Once the PR is resolved, either by being merged or closed, you're free to delete the branch or even the entire fork.

If your PR was merged, you'll be mentioned in the next release's changelog where you will live in infamy. ✨

![](/img/guides/contribution-guide/release.png)

[cms-repo]: https://github.com/statamic/cms

## Extra Credit
If you're a frequent contributor, you may consider permanently setting up the Composer path repository.

Instead of adding `repositories` key into your sandbox's `composer.json` every time, you can add it to your global Composer `~/.composer/config.json`.

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "/path/to/cms",
            "canonical": false
        }
    ]
}
```
