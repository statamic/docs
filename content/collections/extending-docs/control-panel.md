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

### Using Vite (recommended) {#using-vite}
[Vite](https://vite.dev/) is a modern frontend build tool and recommended in the Statamic and Laravel ecosystems.

A fresh Statamic install will have Vite ready to go (using the Laravel Vite wrapper plugin) and is the fastest way for you to add CSS and JavaScript to the Control Panel.

The code snippets below will already be in your site but commented out. They just need to be uncommented.

You may register a Vite asset to be loaded in the Control Panel using the `vite` method. This will accept a vendor name and an array of paths. For your application specific modifications, `app` will probably do just fine as a vendor name.

```php
use Statamic\Statamic;

class AppServiceProvider
{
    public function boot()
    {
        Statamic::vite('app', [ // [tl! ++:start]
            'resources/js/cp.js',
            'resources/css/cp.css'
        ]); // [tl! ++:end]
    }
}
```

Your `vite.config.js` can contain files for your front-end and the control panel. You'll need to add the control panel input files.

If you plan to create Vue-based features (such as fieldtypes), you will need to make sure the vue2 npm package is installed. 


```bash
npm i --save-dev @vitejs/plugin-vue2
```

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

Now you are ready to add JS code to `cp.js`:

```php
alert('Ready to code!');
```

To start Vite, run `npm run dev`. The control panel will automatically reload your changes as you work. 

When you're ready to deploy to production, you can run `npm run build`. 

### Using Webpack

While Vite is the recommended build tool for adding assets to the control panel, you are welcome to use other tools.

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

### Using `<script>` tags in the Control Panel

For externally-hosted scripts, you may register assets to be loaded in the Control Panel with the `externalScript` method. This method accepts the URL of an external script.


```php
use Statamic\Statamic;

class AppServiceProvider
{
    public function boot()
    {
        Statamic::externalScript('https://kit.fontawesome.com/5t4t4m1c.js');
    }
}
```

Otherwise, for inline scripts, you may use the `inlineScript` method. You should omit the `<script>` tags.

```php
use Statamic\Statamic;

class AppServiceProvider
{
    public function boot()
    {
        Statamic::inlineScript('window.Beacon("init", "abc123")');
    }
}
```


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
