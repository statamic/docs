---
title: Installation
intro: 'During the **Alpha** phase you''ll need to do a bit of extra wangjangling. All of these additional, annoying steps will be eliminated when we make the Github repo public.'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568743917
template: page
id: ab08f409-8bbe-4ede-b421-d05777d292f7
stage: 1
---
## Composer

Statamic utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using Statamic, make sure you have Composer installed on your machine.

## Alpha prerequisites

Once Statamic is out of alpha, Statamic will be publicly available on [Packagist][packagist]. During the alpha period, you'll need to maintain a local versions of the packages, which Composer will reference when you create your sites.

1. Clone the `statamic/cms` package.

    ``` bash
    git clone git@github.com:statamic/three-cms.git
    ```

2. Clone the `statamic/statamic` package.

    ``` bash
    git clone git@github.com:statamic/three-statamic.git
    ```

3. Compile `statamic/cms`'s assets.

    ``` bash
    cd three-cms
    npm install && npm run dev
    ```

4. Add the packages as path repositories, globally, inside `~/.composer/config.json`

    ``` json
    {
        "repositories": [
            {
                "type": "path",
                "url": "/path/to/where/you/cloned/three-cms"
            },
            {
                "type": "path",
                "url": "/path/to/where/you/cloned/three-statamic",
                "options": {
                    "symlink": false
                }
            }
        ]
    }
    ```

## Creating a new Statamic project

1. Use Composer to create a project based off the `statamic/statamic` starter site.

    ```.language-bash
    composer create-project statamic/statamic my-blank-site --stability=dev
    ```

## Installing into existing Laravel apps

1. Add the `statamic:install` command to `post-autoload-dump`.

    ``` json
    "post-autoload-dump": [
        "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
        "@php artisan package:discover --ansi",
        "@php artisan statamic:install --ansi"
    ]
    ```

2. Require `statamic/cms` (and `statamic/definitely-not-v3` during alpha).

   ``` json
   composer require statamic/cms statamic/definitely-not-v3
   ```

3. If you plan to use the Control Panel, follow the instructions in the [Users](/users#storage) guide to learn how to make your existing users compatible with Statamic, or how to switch to Statamic's file-based user driver.


## Core Development

While working on the core, or during alpha, where there would be frequent css/js updates, it could be a good idea to symlink assets to prevent needing to continually publish them.

Delete `public/vendor/statamic/cp`, and symlink the CP `resources/dist` directory from your `three-cms` repo.

``` bash
rm -rf public/vendor/statamic/cp
ln -s /path/to/cms/resources/dist public/vendor/statamic/cp
```

[users]: /users
[packagist]: https://packagist.org/
