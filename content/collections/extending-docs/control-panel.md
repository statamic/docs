---
title: 'Control Panel'
nav_title: Overview
template: page
parent: caf2a160-de1c-11e9-aaef-0800200c9a66
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569263726
intro: The control panel may be customized in a number of different ways. You may add new fieldtypes, widgets, a stylesheet, or maybe you just want to add some arbitrary Javascript.
stage: 1
id: cb8f4d8a-47b6-4567-9510-ed7d9ee9c037
---

If you're [creating an addon](/extending/addons), they will have their own ways to add things to the Control Panel. This guide is for adding for your own app.

## Adding CSS and JS assets

Statamic can load extra stylesheets and Javascript files located in the `public/vendor/` directory.

You may register an asset to be loaded in the Control Panel using the `script` and `style` methods. This will accept a vendor name and a path.

For your application specific modifications, `app` will probably do just fine as a vendor name.

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

These commands will make Statamic expect files at `public/vendor/app/js/cp.js` and `public/vendor/app/css/cp.css` respectively.

> This, as well as the webpack config below are already included in the `statamic/statamic` starter site. You just have to uncomment them in `app/Providers/AppServiceProvider.php`.

## Adding assets to your build process

Rather than writing flat CSS and JS files directly into the `public` directory, you can (and should) set up source files to output there instead.

Add the following to your `webpack.mix.js`, adjusting the location of your source files as necessary:

``` js
mix.js('resources/js/cp.js', 'public/vendor/app/js')
   .sass('resources/sass/cp.scss', 'public/vendor/app/css');
```

The `cp.js` in this example may be your entry point for loading various other files. For instance, you could import fieldtypes:

``` files
resources/
`-- js/
    |-- cp.js
    `-- components/
        `-- fieldtypes/
            `-- Password.vue
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

> You may of course change filenames and folder structure, and even your entire build process. The important thing is to compiled imported files with `Statamic::script()`

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
