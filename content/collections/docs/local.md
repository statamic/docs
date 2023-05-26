---
id: 2093f557-8d4a-4baf-bf5c-cbbf584acd3b
blueprint: page
title: 'How to Install Statamic Locally'
nav_title: Local
intro: 'Fast-track local install for getting Statamic running on your computer or development machine.'
parent: ab08f409-8bbe-4ede-b421-d05777d292f7
---
## Overview

Running Statamic locally is the preferred method for building and maintaining your sites. With version control (we recommend git), it's quite simple to deploy changes almost instantly from your local computer to a live site with a single command.

:::watch https://youtube.com/embed/zuKZQNUYSf8
Feel free to watch instead of read!
:::

:::tip Heads up!
This video assumes you're serving your local sites using [Laravel Valet][valet].
:::

## Prerequisites

To install Statamic locally you will need the following:

- A computer running MacOS, Windows, or Linux
- A supported version of [PHP](https://php.net) (we recommend PHP 8)
- [Composer](https://getcomposer.org) to manage PHP packages

## Install Statamic CLI

Statamic CLI is a commandline tool to help you get Statamic installed quickly and easily. The package can be installed on your machine using Composer:

``` shell
composer global require statamic/cli
```

Once installed, you can run the command `statamic list` to see a list of available commands.

:::tip
If you run into any issues or errors, check out this [helpful article](/troubleshooting/fixing-issues-with-global-composer-packages) on what to do next.
:::

## Install Statamic
In your terminal, `cd` to the directory you want to start a new Statamic project in and run the install command.

``` shell
statamic new $project_name
```

You'll be asked if you want to install a blank site or a [Starter Kit](/starter-kits). If this is your first time, we usually recommend starting with a blank site. Keep it simple.

Next, you'll be prompted to set up your first super admin user. Do it.

_After that_, everything is finished!

## Accessing the site

The address where you access the site will be different depending on your development environment.

For example, if you're using [Valet][valet] then your site would be at `http://$project_name.test` and the Control Panel at `/cp`.

If you don't have Valet or some other server set up, you can run `php artisan serve` to use the built-in server, then use the URL it provides, (which is typically `http://127.0.0.1:8000`).

```cli
$ php artisan serve
Starting Laravel development server: http://127.0.0.1:8000
```

## Troubleshooting

If your local environment is reasonably "up to date", everything should have gone smoothly. But let's face it, tech doesn't always work the way it's supposed to on the [first try](https://www.youtube.com/watch?v=3KDnrGdpNZY).

Check out the [troubleshooting section](/troubleshooting) to get help about common error messages.

## What's Next

You're now (probably) running the latest and greatest version of Statamic! Well done! 🎉 You can now get on with the fun parts.

The [Quick Start Guide](/quick-start-guide) is a great place to head next if you're just kicking the tires (or tyres — if you're not from our neck of the woods).

:::tip
You can use Pro features while in development (like users, permissions revisions, REST API, and so on), by setting `'pro' => true` in `config/statamic/editions.php`.
:::

:::tip Another Hot Tip
The default install and all first-party Starter Kits use [TailwindCSS](https://tailwindcss.com/docs/just-in-time-mode) in Just In Time mode, so anytime you change classes in your HTML you'll need to recompile your CSS.

This is super easy and happens automatically when you run `npm run dev` from the terminal in your project directory (as long as you've run `npm install` first).
:::

[valet]: https://laravel.com/docs/valet
