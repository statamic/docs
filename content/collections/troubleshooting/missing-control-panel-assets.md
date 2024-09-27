---
id: 6056f7d0-f767-496d-a8b0-e1242f69faa2
blueprint: troubleshooting
title: 'Missing Control Panel Assets (Vite manifest not found)'
template: page
categories:
  - troubleshooting
---
You've just installed Statamic and are ready to jump into the Control Panel. You head to `/cp` and are met with a `Vite manifest not found` error.

![](/img/vite-manifest-not-found.png)

The most likely reason for this is that **you have Composer plugins disabled**.

There may be a number of reasons why they are disabled, such as:
- You answered no when it asked if you want to trust the plugin
- You have them disabled in your global composer config
- Your Docker setup doesn't allow them 

Regardless, you'll need to at least enable one. When installing or updating Statamic via Composer, we use the `pixelfear/composer-dist-plugin` plugin to copy the assets into the appropriate location.

1. You may explicitly allow it by adding the following to your `composer.json`.

    ```json
    {
        "name": "statamic/statamic",
        "require": {},
        "autoload": {},
        "config": { // [tl! **]
            "optimize-autoloader": true,
            "preferred-install": "dist",
            "sort-packages": true,
            "allow-plugins": { // [tl! **]
                "pestphp/pest-plugin": true,
                "php-http/discovery": true,
                "pixelfear/composer-dist-plugin": true // [tl! ** ++]
            } // [tl! **]
        }, // [tl! **]
        "minimum-stability": "dev",
        "prefer-stable": true
    }
    ```

2. Delete the `vendor/statamic/cms` directory. This will force Composer to re-download Statamic in the next step.
    ```bash
    rm -rf vendor/statamic/cms   
    ```
3. Update Statamic
    ```bash
    composer update statamic/cms
    ```

:::tip
For Docker specifically, you may be able to avoid this in the future by adding this to your `Dockerfile` before any `composer` commands:

```dockerfile
ENV COMPOSER_ALLOW_SUPERUSER=1
```
:::
