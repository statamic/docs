---
title: CLI
intro: Statamic provides developers a nice long list of scripts available in the command line. They can clear caches, create users, generate addon and extension classes, and perform other time-saving tasks. In short, they make a developer's job easier and more enjoyable.
template: page
id: 83145e6c-45d2-4e9c-a412-48a81f144224
blueprint: page
---
## Overview

Statamic's CLI commands are built with [Laravel's Artisan Console package][artisan]. To view the list of Statamic-specific commands, you may use the `please list` command:

``` shell
php please list
```

To see _all_ commands available, including those provided by Laravel, use the `artisan list` command.

``` shell
php artisan list
````

## Artisan vs Please

There is no functional difference between Artisan and Please. `please` is merely an alias for `php artisan statamic:`. We just think manners are still important and it feels nice to treat your command line with respect, while saving you a little time typing.

``` shell
# These are equivalent
php please make:user
php artisan statamic:make:user
```

Every command also includes a help screen which displays and describes the command's available arguments and options. To view a help screen, precede the name of the command with help:

``` shell
php please help make:user
```

## Available commands {#commands}

You can see the list of available commands in your terminal by running `php please list`. But for those who don't feel like it, haven't installed yet, or are scared of the command line, here they are also.

| Command | Description |
|---------|-------------|
| `install`          | Install Statamic |
| `list`             | List all the Statamic commands |
| `multisite`        | Converts from a single to multisite installation |
| `addons:discover`  | Rebuild the cached addon package manifest |
| `assets:clear-cache` | Clear the `asset_meta` and `asset_container_contents` cache stores |
| `assets:generate-presets` | Generate asset preset manipulations |
| `assets:meta`      | Generate asset metadata files |
| `auth:migration`   | Generate Auth Migrations |
| `eloquent:import-groups` | Imports file based groups into the database. |
| `eloquent:import-roles` | Imports file based roles into the database. |
| `eloquent:import-users` | Imports file based users into the database. |
| `flat:camp` | Flat Camp ⛺ |
| `glide:clear`      | Clear the Glide image cache |
| `install:collaboration` | Installs the Statamic Collaboration addon and enables broadcasting in Laravel. |
| `install:eloquent-driver` | Install & configure Statamic's Eloquent Driver package |
| `install:ssg` | Install & configure Statamic's Static Site Generator package |
| `license:set` | Set Statamic license key in .env |
| `make:action`      | Create a new action |
| `make:addon`       | Create a new addon |
| `make:dictionary`  | Create a new dictionary |
| `make:fieldtype`   | Create a new fieldtype |
| `make:filter`      | Create a new filter |
| `make:modifier`    | Create a new modifier |
| `make:scope`       | Create a new query scope |
| `make:tag`         | Create a new tag |
| `make:user`        | Create a new user account |
| `make:widget`      | Create a new widget |
| `nocache:migration` | Generate Nocache Migrations |
| `pro:enable`      | Enable Statamic Pro in .env |
| `search:insert`    | Insert an item into its search indexes |
| `search:update`    | Update a search index |
| `site:clear`       | Start a fresh site, wiping away all content |
| `stache:clear`     | Clear the "Stache" cache |
| `stache:doctor`    | Diagnose any problems with the Stache. |
| `stache:refresh`   | Clear and rebuild the "Stache" cache |
| `stache:warm`      | Build the "Stache" cache |
| `starter-kit:export`  | Export a starter kit package |
| `starter-kit:install`  | Install a starter kit |
| `static:clear`     | Clear the static page cache |
| `static:warm`      | Warm the static cache by crawling all URLs |
| `support:details`  | List useful details to help with support |
| `support:zip-blueprint`  | Create a zip file with a blueprint and all fieldset imports |
| `updates:run`      | Run update scripts from a specific version |

## Additional reading

Read more about [Artisan][artisan] at Laravel.com.

[artisan]: https://laravel.com/docs/artisan
