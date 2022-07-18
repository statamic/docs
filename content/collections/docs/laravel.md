---
id: e48bde09-8957-401a-a2b4-ba7a4fd26d67
blueprint: page
title: 'How to Install into an Existing Laravel Application'
breadcrumb_title: Laravel
intro: Statamic can be installed **into** an existing Laravel application and used to add new sections — like a blog or press release section — function as a headless CMS, or even manage existing data.
parent: ab08f409-8bbe-4ede-b421-d05777d292f7
---
## Overview

There are many reasons why you might want to install Statamic into an existing Laravel application. You could use Statamic to:

- handle all the marketing and "logged out" content for a SaaS app
- add an easy-to-manage blog the whole team can update
- manage existing data kinda like [Laravel Nova](https://nova.laravel.com/) (yes, [you can do that](/extending/repositories)),
- run as a headless CMS and provide a REST API to your data
- be a special comfort package for those tough projects even when you don't need it

## Supported Versions of Laravel

**Laravel 8 and Laravel 9 are supported.** It feels like this section needs more than one sentence but it really doesn't. That first one said all that needs saying.

## Install Statamic

There are 3 steps to follow to install Statamic into your Laravel app.

1. Run `php artisan config:clear` to make sure your config isn't cached.

2. Add the `statamic:install` command to `post-autoload-dump` in `composer.json`.

    ``` json
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi",
            "@php artisan statamic:install --ansi", // [tl! **]
            "@php artisan statamic:search:update --all --ansi",
            "@php artisan statamic:static:clear --ansi"
        ],
    }
    ```

3. Install `statamic/cms` with Composer.

    ``` shell
    composer require statamic/cms --with-dependencies
    ```

## Regarding Users

If you want to continue to keep users in a database, head over to [Storing Users in a Database in an Existing Laravel App](/tips/storing-users-in-a-database#in-an-existing-laravel-app) follow those steps.

Otherwise, the [Storing User Records](/users#storage) page should have instructions for the most common scenarios.

## New Statamic Directories

After Statamic is installed, you'll have 3 new directories in your project:
- `content/`,
- `users/`
- `config/statamic/`

:::tip
**Statamic relies on a "catch-all" wildcard route to handle its URLs.** Any explicitly defined routes in your application will take precedence over those handled by Statamic. Be sure that you don't have _your own_ catch-all route or else nothing will ever be passed off to Statamic.
:::
