---
title: Installing
intro: Statamic utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using Statamic, make sure you have Composer installed on your machine.
template: page
id: ab08f409-8bbe-4ede-b421-d05777d292f7
blueprint: page
video: https://youtu.be/zuKZQNUYSf8
---
## Creating a new Statamic project?

If you're starting a new site from scratch, we recommend using one of the following methods.

### Via Statamic CLI Installer (preferred method) {#cli}

First, download the Statamic CLI installer using Composer:

```
composer global require statamic/cli
```

Make sure to place Composer's system-wide vendor bin directory in your `$PATH` so the `statamic` executable can be located by your system.
[Here's how](/troubleshooting/command-not-found-statamic).

:::tip
If you run into any errors, check out this [helpful article](/troubleshooting/fixing-issues-with-global-composer-packages) on what to do next.
:::

**Once installed,** run the following command to kickstart a fresh new Statamic project (and even choose from some free Starter Kits).

``` bash
statamic new {site_name}
```

### Via Composer

You can install Statamic with regular, old Composer if you'd prefer. To do so, you'll probably want to use the [`statamic/statamic`](https://github.com/statamic/statamic) empty starter site.

``` bash
composer create-project --prefer-dist statamic/statamic {site_name}
```

After you've installed, make sure to point your web server to your `public` folder. If you use Laravel Valet, that will be automatically picked up.

### Starter Kits
Looking to jump right into a ready-made site?

**Official Starter Kits**

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <a href="https://github.com/statamic/starter-kit-starters-creek" class="rounded custom bg-blue-lightest hover:text-black no-underline flex border shadow-md p-3 font-display relative">
        <div>
            <div class="font-bold">Starter's Creek</div>
            <div class="text-black text-xs">A beautiful, multi-author capable blog.</div>
        </div>
    </a>
    <a href="https://github.com/statamic/starter-kit-cool-writings" class="rounded custom bg-blue-lightest hover:text-black no-underline flex border shadow-md p-3 font-display relative">
        <div>
            <div class="font-bold">Cool Writings</div>
            <div class="text-black text-xs">A super clean, Markdown focused blog.</div>
        </div>
    </a>
    <a href="https://github.com/statamic/starter-kit-doogie-browser" class="rounded custom bg-blue-lightest hover:text-black no-underline flex border shadow-md p-3 font-display relative">
        <div>
            <div class="font-bold">Doogie Browser</div>
            <div class="text-black text-xs">A retro, IBM/VGA inspired journaling blog.</div>
        </div>
    </a>
</div>

**Community Starter Kits**

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <a href="https://github.com/doublethreedigital/docs-starter-kit" class="rounded custom bg-blue-lightest hover:text-black no-underline flex border shadow-md p-3 font-display relative">
        <div>
            <div class="font-bold">Docs</div>
            <div class="text-black text-xs">Quick start your documentation website.</div>
        </div>
    </a>
    <a href="https://github.com/doublethreedigital/sc-starter-kit" class="rounded custom bg-blue-lightest hover:text-black no-underline flex border shadow-md p-3 font-display relative">
        <div>
            <div class="font-bold">Simple Commerce</div>
            <div class="text-black text-xs">Pairs with the Simple Commerce addon to quick start your ecommerce website.</div>
        </div>
    </a>
    <a href="https://github.com/jonassiewertsen/statamic-butik-starter-kit" class="rounded custom bg-blue-lightest hover:text-black no-underline flex border shadow-md p-3 font-display relative">
        <div>
            <div class="font-bold">Butik</div>
            <div class="text-black text-xs">Pairs with the Butik addon to quickly start your new online Butik.</div>
        </div>
    </a>
    <a href="https://github.com/studio1902/statamic-peak" class="rounded custom bg-blue-lightest hover:text-black no-underline flex border shadow-md p-3 font-display relative">
        <div>
            <div class="font-bold">Peak</div>
            <div class="text-black text-xs">An opinionated starter kit for bespoke client websites featuring a page builder and more.</div>
        </div>
    </a>
</div>

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
   composer require statamic/cms --with-dependencies
   ```

3. Head over to the [Storing User Records](/users#storage) section and follow the instructions for the scenario that makes sense for your project. If you want to continue to keep users in a database, you can jump straight over to [Storing Users in a Database in an existing Laravel app](/troubleshooting/storing-users-in-a-database#in-an-existing-laravel-app).

After Statamic is installed, you'll have the `content/`, `users/`, and `config/statamic` directories added to your project. Your app will continue to work as before and you'll have Statamic available at your fingertips.

Your explicit routes will take precedence and anything not caught by your app will run through Statamic and will work as documented. Enjoy!

Make sure your Laravel config is *not* cached before installing Statamic. If you're not sure run `php artisan config:clear`.

## Next Steps

Once you've installed Statamic, you're ready to start building! Check out the [Quick Start](/quick-start) page for a walkthrough on how to build a simple site, access the Control Panel, creating a user, and more.

:::tip
You can use Pro features while in development (like users, permissions revisions, REST API, and so on), by setting `'pro' => true` in `config/statamic/editions.php`.
:::

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

:::tip
Updating via the CP will lock that specific version of `statamic/cms` in your `composer.json`. If you want to update using the command line later, you'll need to update the version manually before running `composer update`.
:::

[users]: /users
[packagist]: https://packagist.org/
