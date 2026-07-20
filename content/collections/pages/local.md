---
id: 2093f557-8d4a-4baf-bf5c-cbbf584acd3b
blueprint: page
title: 'How to Install Statamic with the CLI'
nav_title: CLI
intro: 'Install Statamic anywhere you already have PHP and Composer — Linux, custom environments, or anytime you prefer the terminal over a guided Herd setup.'
parent: ab08f409-8bbe-4ede-b421-d05777d292f7
---
## Overview

On Mac or Windows and just getting started? Use **[Laravel Herd](/installing/laravel-herd)** instead. It installs PHP, Composer, and a local web server for you — that's our recommended path.

This page is the CLI-first install for when you already have a working PHP environment (or you're on Linux and setting things up yourself). Same end result: a fresh Statamic site via `statamic new`.

## Prerequisites

You'll need:

- A computer running macOS, Windows, or Linux
- [PHP 8.3+](https://php.net) with the [required extensions](/requirements)
- [Composer](https://getcomposer.org) to manage PHP packages

macOS and Windows users who don't already have these: install [Laravel Herd](/installing/laravel-herd). It gives you PHP, Composer, and npm in one shot.

## Install Statamic CLI

``` shell
composer global require statamic/cli
```

Confirm it worked:

``` shell
statamic list
```

:::tip
Hit a `command not found` or PATH issue? See [troubleshooting global Composer packages](/troubleshooting/fixing-issues-with-global-composer-packages) and [command not found: statamic](/troubleshooting/command-not-found-statamic).
:::

The CLI is a nicer wrapper around `composer create-project`. You can skip it and run `composer create-project statamic/statamic project_name` if you prefer — you'll just miss the setup wizard (starter kits, first user, git init).

## Create a new site

`cd` to wherever you keep projects and run:

``` shell
statamic new project_name
```

You'll be asked whether you want a blank site or a [Starter Kit](/starter-kits). First time? Blank site. Keep it simple.

Then create your first super user when prompted. Do it.

If you're using [Herd](https://herd.laravel.com), create the site inside your Herd directory (usually `~/Herd`) so it gets a `*.test` URL automatically.

## Accessing the site

How you hit the site depends on your environment:

| Environment | Frontend | Control Panel |
| --- | --- | --- |
| [Laravel Herd](/installing/laravel-herd) | `http://project_name.test` | `/cp` |
| Built-in PHP server | run `php artisan serve` → usually `http://127.0.0.1:8000` | `/cp` |

```cli
$ php artisan serve
Starting Laravel development server: http://127.0.0.1:8000
```

Herd (or any proper local nginx/valet-style setup) is nicer for day-to-day work — pretty URLs, multiple sites, no juggling ports. `artisan serve` is fine for a quick smoke test.

## Troubleshooting

If your environment is current, this usually Just Works™. When it doesn't, check the [troubleshooting section](/troubleshooting) for common error messages.

## What's Next

You're running Statamic. Nice. 🎉

Head to the [Quick Start Guide](/quick-start-guide) if you're kicking the tires, or [Laracasts](https://laracasts.com/series/learn-statamic-with-jack) if you'd rather watch someone else click around first.

:::tip
Use Pro features while developing (users, permissions, GraphQL, REST API, and more) by setting `'pro' => true` in `config/statamic/editions.php`.
:::
