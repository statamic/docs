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
composer create-project statamic/statamic my-site --prefer-dist --stability=dev
```

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

3. If you plan to use the Control Panel, follow the instructions in the [Users](/users#storage) guide to learn how to make your existing users compatible with Statamic, or how to switch to Statamic's file-based user driver.

## Updating

From within your project, use Composer to update the Statamic CMS package:

``` bash
composer update statamic/cms --with-dependencies
```

[users]: /users
[packagist]: https://packagist.org/
