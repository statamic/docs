---
title: 'Control Panel'
nav_title: Overview
template: page
intro: The control panel may be customized in a number of different ways. You may add new fieldtypes, widgets, a stylesheet, or maybe you just want to add some arbitrary Javascript.
stage: 1
id: cb8f4d8a-47b6-4567-9510-ed7d9ee9c037
---

If you're [creating an addon](/extending/addons), they will have their own ways to add things to the Control Panel. This guide is for adding for your own app.

## Adding CSS and JS assets

Statamic can load custom stylesheets and Javascript files located in the `public/vendor/` directory, or from external sources.

### Using Vite
You may register a Vite asset to be loaded in the Control Panel using the `vite` method. This will accept a vendor name and an array of paths.

For your application specific modifications, `app` will probably do just fine as a vendor name.

```php
use Statamic\Statamic;

class AppServiceProvider
{
    public function boot()
    {
        Statamic::vite('app', [
            'resources/js/cp.js',
            'resources/css/cp.css'
        ]);
    }
}
```

:::tip
This, as well as the Vite config below are already included in the `statamic/statamic` starter site. You just have to uncomment them in `app/Providers/AppServiceProvider.php`.
:::

### Using Webpack

If you're using Webpack, Laravel Mix, or some other tool, you may register an asset to be loaded in the Control Panel using the `script` and `style` methods. This will accept a vendor name and a path.


``` php
use Statamic\Statamic;

class AppServiceProvider
{
    public function boot()
    {
        Statamic::script('app', 'cp.js');
        Statamic::style('app', 'cp.css');
    }
}
```

These methods will make Statamic expect files at `public/vendor/app/js/cp.js` and `public/vendor/app/css/cp.css` respectively.

### Using External Scripts

For externally-hosted sources, you may register assets to be loaded in the Control Panel with the `externalScript` method. This method accepts the URL of an external script.


``` php
use Statamic\Statamic;

class AppServiceProvider
{
    public function boot()
    {
        Statamic::externalScript('https://kit.fontawesome.com/5t4t4m1c.js');
    }
}
```

## Adding assets to your build process

Rather than writing flat CSS and JS files directly into the `public` directory, you can (and should) set up source files to output there instead.

Add the following to your `vite.config.js`, adjusting the location of your source files as necessary:

``` js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue2 from '@vitejs/plugin-vue2'; // [tl! ++]

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/site.css',
                'resources/js/site.js',
                'resources/css/cp.css',  // [tl! ++]
                'resources/js/cp.js',  // [tl! ++]
            ],
            refresh: true,
        }),
        vue2(), // [tl! ++]
    ],
});
```

```bash
npm i --save-dev @vitejs/plugin-vue2
```

The `cp.js` in this example may be your entry point for loading various other files. For instance, you could import fieldtypes:

``` files theme:serendipity-light
resources/
    js/
        cp.js
        components/
            fieldtypes/
                Password.vue
```

``` js
// resources/js/cp.js
import Password from './components/fieldtypes/Password.vue';

Statamic.booting(() => {
    Statamic.$components.register('password-fieldtype', Password);
});
```

``` vue
// resources/js/components/fieldtypes/Password.vue
<template>
    ...
</template>
<script>
export default {
    //
}
</script>
```

:::tip
You are welcome to customize the filenames and folder structure and even the entire build process. The only important thing is to import the files with `Statamic::vite()` (or `Statamic::script()`).
:::

## Adding control panel routes

If you need to have custom routes for the control panel:

1. Create a routes file. Name it whatever you want, for example: `routes/cp.php`
2. Then push the routes by adding this to your `app/Providers/AppServiceProvider.php`:

    ```php
    use Illuminate\Support\Facades\Route;
    use Statamic\Statamic;

    public function boot()
    {
        Statamic::pushCpRoutes(function () {
            Route::namespace('\App\Http\Controllers')->group(function () {
                require base_path('routes/cp.php');
            });
        });
    }
    ```

3. Any routes in the file will have the appropriate name prefix and middleware applied.
