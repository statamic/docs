---
title: Installing
intro: During the **Alpha** phase you'll need to do a bit of extra wangjangling. All of these additional, annoying steps will be eliminated when we make the Github repo public.
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1567091687
id: ab08f409-8bbe-4ede-b421-d05777d292f7
---
## Fresh Installation

Statamic utilizes Composer to manage its dependencies. So, before using Statamic, make sure you have Composer installed on your machine.

Next, download the Statamic installer with Composer. You only need to do this once on your machine.

```.language-bash
composer global require statamic/cli
```

Then run the following command to install Statamic into any `myproject` directory:

```.language-bash
statamic new myproject
```

## Fresh Installation (Alpha Edition)

1. Clone github.com/statamic/three-cms.
2. `cd` into `three-cms` and run `npm install && npm run dev`
3. Install a Laravel app.

    ```.language-bash
    laravel new myproject --dev
    ```

4. Open `composer.json` and add a `repositories` object that points to the `three-cms` repo.

    ```.language-json
    "repositories": [
        {
            "type": "path",
            "url": "../cms"
        }
    ]
    ```

5. Require `statamic/cms` (and `statamic/definitely-not-v3` to suppress version error).

    ```.language-json
    "require": {
        "statamic/cms": "dev-master",
        "statamic/definitely-not-v3": "^3.0"
    }
    ```

6. Add the `statamic:install` to `post-autoload-dump`.

    ```.language-json
    "post-autoload-dump": [
        "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
        "@php artisan package:discover",
        "@php artisan statamic:install"
    ]
    ```

7. Composer update.

    ```.language-bash
    composer update
    ```

8. Delete `public/vendor/statamic/cp`, and symlink the CP `resources/dist` directory from your `three-cms` repo.

    ```.language-bash
    rm -rf public/vendor/statamic/cp
    ln -s /path/to/cms/resources/dist public/vendor/statamic/cp
    ```

## Installing into existing Laravel apps

1. Run `composer require statamic/cms`
2. Run `php artisan statamic:install`
3. Add the post autoload command as per step 5 of the dev fresh install steps.
