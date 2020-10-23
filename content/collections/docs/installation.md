---
title: Installation
intro: Statamic utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using Statamic, make sure you have Composer installed on your machine.
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568743917
template: page
id: ab08f409-8bbe-4ede-b421-d05777d292f7
stage: 4
video: https://youtu.be/zuKZQNUYSf8
---
## Creating a new Statamic project?

If you're starting a new site from scratch, we recommend using use one of the following methods.

### Via Statamic CLI Installer (preferred method) {#cli}

First, download the Statamic CLI installer using Composer:

```
composer global require statamic/cli
```


Make sure to place Composer's system-wide vendor bin directory in your `$PATH` so the `statamic` executable can be located by your system. This directory exists in different locations based on your operating system; however, some common locations include:

- MacOS: `$HOME/.composer/vendor/bin`
- Windows: `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin`
- GNU / Linux Distributions: `$HOME/.config/composer/vendor/bin` or `$HOME/.composer/vendor/bin`

Once installed, you will be able to run `statamic new {site_name}` to install a fresh copy of Statmaic. You'll even be given the option to start with one of our ready-made Starter Kits.

### Via Composer

You can install Statamic with regular, old Composer if you'd prefer. To do so, you'll probably want to use the [`statamic/statamic`](https://github.com/statamic/statamic) empty starter site.

``` bash
composer create-project --prefer-dist statamic/statamic {site_name}
```

After you've installed, make sure to point your web server to your `public` folder. If you use Laravel Valet, that will be automatically picked up.

### Starter Kits

You can also use one of the starter kits to jump ahead with a pre-built site. Each starter kit has its own installation docs.

- [Cool Writings](https://github.com/statamic/starter-kit-cool-writings)
- [Doogie Browser](https://github.com/statamic/starter-kit-doogie-browser)

## You can also install into an _existing_ Laravel app {#exising-laravel}

1. Add the `statamic:install` command to `post-autoload-dump` in `composer.json`.

    ``` json
    "post-autoload-dump": [
        "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
        "@php artisan package:discover --ansi",
        "@php artisan statamic:install --ansi"
    ],
    ```

2. Require `statamic/cms`.

   ``` bash
   composer require statamic/cms
   ```

3. If you have existing users in your application, [follow these instructions](/users#storage) to learn how to make them compatible with Statamic, or how to switch to Statamic's file-based user driver.

After Statamic is installed, you'll have the `content/`, `users/`, and `config/statamic` directories added to your project. Your app will continue to work as before and you'll have Statamic available at your fingertips.

Your explicit routes will take precedence and anything not caught by your app will run through Statamic and will work as documented. Enjoy!

## Next Steps

Once you've installed Statamic, you're ready to start building! Check out the [Quick Start](/quick-start) page for a walkthrough on how to build a simple site, access the Control Panel, creating a user, and more.

> If you want to use Pro features while in development (like users, permissions & groups, revisions, and git integration), set `'pro' => true` in `config/statamic/editions.php`.

Want to jump right in? You can create a user by running `php please make:user`, and heading to `http://yoursite.com/cp`.

## Updating

Statamic is updated using Composer either directly on the command line or through the Control Panel.

### Command Line

From within your project, use Composer to update the Statamic CMS package:

``` bash
composer update statamic/cms --with-dependencies
```

You may prefer to run `composer update` to update _all_ of your dependencies listed in your composer.json file

### Control Panel

You may also update Statamic from within the Control Panel. Head to the "Updates" section and click update.

> Updating via the CP will lock that specific version of `statamic/cms` in your `composer.json`. If you want to update using
> the command line later, you'll need to update the version manually before running `composer update`.

[users]: /users
[packagist]: https://packagist.org/
