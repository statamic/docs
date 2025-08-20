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
[Vite](https://vite.dev) is the recommended frontend build tool in the Statamic and Laravel ecosystems. 

To set up Vite for the Control Panel, run the setup command:

```bash
php please setup-cp-vite
```

It will install the necessary dependencies, create a `vite-cp.config.js` file, and publish any necessary stubs.

You can add any CSS to the `resources/css/cp.css` file, and any JavaScript to the `resources/js/cp.js` file. 

To start Vite, run `npm run cp:dev` and to build for production, run `npm run cp:build`.

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
