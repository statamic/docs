---
title: CLI
template: page
id: 83145e6c-45d2-4e9c-a412-48a81f144224
blueprint: page
---
## Overview

[Artisan][artisan] is the command-line interface included with Laravel. It provides a number of helpful commands that can assist you while building applications.

To view a list of all available Artisan commands, you may use the list command:

``` bash
php artisan list
```

Statamic has a number of commands that help you manage your site, ranging from utilities to clear various caches, generators to make users and addons, and more. We've aliased all of these Statamic-specific commands into our polite little `please` command. We think manners are still important.

``` bash
# Show only Statamic commands
php please list

# These are equivelant
php please make:user
php artisan statamic:make:user
```

Every command also includes a help screen which displays and describes the command's available arguments and options. To view a help screen, precede the name of the command with help:

``` bash
php please help make:user
```

## Commands

You can see the list of available commands in your terminal by running `php please list`. But for those who don't feel like it, haven't installed yet, or are scared of the command line, here they are also.

| Command | Description |
|---------|-------------|
| `addons:discover`  | Rebuild the cached addon package manifest |
| `assets:meta`      | Generate asset metadata files |
| `auth:migration`   | Generate Auth Migrations |
| `glide:clear`      | Clear the Glide image cache |
| `install`          | Install Statamic |
| `make:addon`       | Create a new addon |
| `make:fieldtype`   | Create a new fieldtype addon |
| `make:modifier`    | Create a new modifier addon |
| `make:scope`       | Create a new query scope addon |
| `make:tag`         | Create a new tag addon |
| `make:user`        | Create a new user |
| `make:widget`      | Create a new widget addon |
| `multisite`        | Converts from a single to multisite installation |
| `search:insert`    | Insert an item into its search indexes |
| `search:update`    | Update a search index |
| `stache:clear`     | Clear the "Stache" cache |
| `stache:doctor`    | Diagnose any problems with the Stache. |
| `stache:refresh`   | Clear and rebuild the "Stache" cache |
| `stache:warm`      | Build the "Stache" cache |
| `static:clear`     | Clear the static page cache |

## Additional Reading

Read more about [Artisan][artisan] at Laravel.com.

[artisan]: https://laravel.com/docs/artisan
