---
id: 421a9f22-bc1c-45e9-81ca-2ba8ad2a5744
blueprint: page
title: Routing
intro: 'You can register Control Panel routes to build custom pages.'
---
:::tip
This guide is intended for apps adding routes to the Control Panel. If you're building an addon, please see our [Building an Addon](/addons/building-an-addon#routing) guide instead.
:::

To register a custom route:

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