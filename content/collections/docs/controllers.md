---
title: Controllers
intro: Controllers group related Laravel request handling logic into single classes stored in the `app/Http/Controllers/` directory. Use them to build frontend areas or full custom apps, the Laravel way!
id: 5e848460-9bbc-449e-8edd-182d918163ff
blueprint: page
---
## Overview

Statamic is a package sitting _inside_ a standard Laravel application, giving you the freedom to create your own routes, map them to controllers, and build your own custom application and business logic outside of Statamic's feature set.

Anything you can do in Laravel you can do here. Because you're using Laravel. You just _also_ have access to all of Statamic's capabilities and features.

## Routes

[Routes][laravel-routes] are defined in `routes/web.php`.

:::tip
These explicitly defined routes will take precedence over Statamic routes and URL patterns. Keep this in mind.
:::

For example, you can map a `GET` request to `yoursite.com/example` to the `index` method in the `app\Http\Controllers\ExampleController.php` file like this:

``` php
use App\Http\Controllers\ExampleController;

Route::get('example', [ExampleController::class, 'index']);
```

## Basic Controller

In your controller, render views like you would in a regular Laravel app:

``` php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Example Title'
        ];

        return view('myview', $data);  // resources/views/myview.blade.php
    }
}
```

:::tip
You can generate a controller with the following [Artisan command](https://laravel.com/docs/artisan):
```shell
php artisan make:controller ExampleController
```
:::

## Antlers Views

Returning `view('myview')` _will_ render the `myview.antlers.html` view. To take advantage of Statamic's standard template-injected-into-a-layout behavior, return a `Statamic\View\View` instance instead of a regular Laravel one.

``` php
public function index()
{
    return (new \Statamic\View\View)
        ->template('myview')
        ->layout('mylayout')
        ->with(['title' => 'Example Title']);
}
```

Now, `myview` will be injected into `mylayout`'s `template_content` variable.
Anything provided to `with` (eg. `title`) will be available in both views.

If you want to make an entry's content available in your view, you can use the `cascadeContent` method:

``` php
// app/Http/Controllers/MySpecialController.php

public function index()
{
    $entry = Entry::whereCollection('pages')
        ->where('slug', 'special-page')
        ->where('published', true)
        ->first();

    return (new \Statamic\View\View)
        ->template('myview')
        ->layout('mylayout');
        ->cascadeContent($entry);
}
```

## Related Reading

- [Laravel Controllers][laravel-controllers]
- [Laravel Routes][laravel-routes]
- [Antlers](/antlers)

[laravel-controllers]: https://laravel.com/docs/controllers
[laravel-routes]: https://laravel.com/docs/routing
