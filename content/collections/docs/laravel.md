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

:::tip
If you're starting a brand new project, it's much easier to use the [standard Statamic installation method](/installing/local).

You'll get a bunch of things automatically set up for you, like a pages collection, views, etc. If you install Statamic _into_ Laravel, you're going to have to do those things manually.
:::

## Supported Versions of Laravel

**Laravel 9 and Laravel 10 are supported with Statamic 4+.** If you need Laravel 8 support, you can still use Statamic 3.x.

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

## Adding Content

When you install Statamic into Laravel this way, **no content or views are included**.

You'll probably want to create a collection and some entries, as well as views and a layout in order to see things appear on the front-end of your site.

### Pages
A common "catch-all" content scenario is to create a Pages collection which allows you to create a home page as well as any other pages in a tree structure. You get this when you install Statamic from scratch, but it's easy to set up yourself.

The easiest way is to copy the `pages.yaml` file and the `pages` directory [from the `statamic/statamic` repository](https://github.com/statamic/statamic/tree/4.x/content/collections).

Or, if you wanted to do it through the Control Panel:

1. Create a collection named `pages`.
    - Set the route to `{parent_uri}/{slug}`
    - Enable the "Orderable" toggle
    - Enabled the "Expect a root page" toggle
2. Create an entry. The first one will be your home page.

### Views

Statamic routed URLs will expect views named `default` and `layout`. You will need to add those manually too.

[Read more about how Statamic views and layouts work](/views)

## Regarding Users

If you want to continue to keep users in a database, head over to [Storing Users in a Database in an Existing Laravel App](/tips/storing-users-in-a-database#in-an-existing-laravel-app) follow those steps.

Otherwise, the [Storing User Records](/users#storage) page should have instructions for the most common scenarios.

## New Statamic Directories

After Statamic is installed, you'll have 3 new directories in your project:
- `content/`,
- `resources/users/`
- `config/statamic/`

:::tip
**Statamic relies on a "catch-all" wildcard route to handle its URLs.** Any explicitly defined routes in your application will take precedence over those handled by Statamic. Be sure that you don't have _your own_ catch-all route or else nothing will ever be passed off to Statamic.
:::
