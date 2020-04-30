---
title: Installation
intro: Statamic utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using Statamic, make sure you have Composer installed on your machine.
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568743917
template: page
id: ab08f409-8bbe-4ede-b421-d05777d292f7
stage: 4
---
## Creating a new Statamic project?

If you want to start from scratch, use Composer to create a project based off the [`statamic/statamic`](https://github.com/statamic/statamic) starter site.

``` bash
composer create-project statamic/statamic {change_me} --prefer-dist --stability=dev
```

_(hint: replace `{change_me}` with whatever you'd like to name your site.)_

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

## Make a new user to use the control panel (optional)
If you want to use the control panel add a new superuser first:

``` bash
php please make:user
```
Read more information about [creating a user](/users#creating-users).

## Open the control panel (optional)
Go to http://cool-site.test/cp or whatever you set it to.

## Updating

From within your project, use Composer to update the Statamic CMS package:

``` bash
composer update statamic/cms --with-dependencies
```

> You may prefer to run `composer update` to update _all_ of your dependencies listed in your composer.json file

[users]: /users
[packagist]: https://packagist.org/
