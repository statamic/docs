---
id: 18906b4f-be9a-4edb-9bb3-366226863fa2
blueprint: page
title: 'How to Install Statamic with Docker'
breadcrumb_title: Docker
intro: Docker is an open source project that streamlines the deployment of an application (or OS) inside a Linux Container. Any dockerized image can run on any machine that is running Docker. You can run Statamic with Docker and never have to configure PHP, Nginx, Apache, or anything else on your local machine.
parent: ab08f409-8bbe-4ede-b421-d05777d292f7
---
## Overview
[Laravel Sail](https://laravel.com/docs/9.x/sail) is a light-weight command-line interface for interacting with Laravel's default Docker development environment. Sail provides a great starting point for building Laravel applications without requiring prior Docker experience, and is a perfect fit for Statamic with a few tweaks.

At its heart, Sail is a `docker-compose.yml` file and script that is stored at the root of your project. The sail script provides a CLI with convenient methods for interacting with the Docker containers defined by the `docker-compose.yml` file.

Laravel Sail is supported on macOS, Linux, and Windows (via WSL2).

:::tip
Since Sail is the starting point for a new Laravel app, we'll be installing Statamic **into** a fresh Laravel app.
:::

## Installing Docker

If you don't already have Docker installed, head to [docker.com/get-started](https://www.docker.com/get-started) and download the latest version for your OS.

## Installing Laravel

Follow the install instructions for creating a fresh Laravel app from [their documentation](https://laravel.com/docs/11.x#creating-a-laravel-project).

Install Laravel Sail into your new Laravel app with no additional services, unless you want to get fancy and use MySQL with Statamic (yes, you can do that).

``` shell
composer require laravel/sail --dev
php artisan sail:install --with=none
```

## Starting and Stopping Sail

:::tip
**Before starting Sail**, ensure that no other web servers or databases are running on your local computer.
:::

To start all of the Docker containers defined in your site's `docker-compose.yml` file, execute the up command:

``` shell
./vendor/bin/sail up
```

To start all of the Docker containers in the background, start Sail in "detached" mode:

``` shell
./vendor/bin/sail up -d
```

Once the application's containers have been started, your project can be accessed in the browser at: http://localhost.

To stop all of the containers, press `Control` + `C`. Or if the containers are running in the background, use the stop command:

``` shell
./vendor/bin/sail stop
```

## Installing Statamic

At this point you're running Laravel without Statamic in it. Time to change that.

You can now follow the steps to [install Statamic into Laravel](/installing/laravel#install-statamic).

:::tip
Keep in mind that  commands need to be run inside Sail.

- Instead of `php artisan`, run `sail artisan`
- Instead of `composer require`, run `sail composer require`
- Instead of `php please`, run `sail artisan statamic`
:::


## Learn more about Laravel Sail

The [Laravel Sail docs](https://laravel.com/docs/9.x/sail) cover a lot more of what you can do with Sail. Check them out!
