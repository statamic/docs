---
title: Controllers
intro: Controllers group related Laravel request handling logic into single classes stored in the `app/Https/Controllers/` directory. Use them to build frontend areas or full custom apps, the Laravel way!
id: 5e848460-9bbc-449e-8edd-182d918163ff
stage: 4
blueprint: page
---
## Overview

Statamic is a package sitting _inside_ a standard Laravel application, giving you have the freedom to create your own routes, map them to controllers, and build your own custom application and business logic outside of Statamic's feature set.

Anything you can do in Laravel you can do here. Because you're using Laravel. You just _also_ have access to all of Statamic's capabilities and features.

## Routes

[Routes][laravel-routes] are defined in `routes/web.php`.

> These explicitly defined routes will take precedence over Statamic routes and URL patterns.

For example, you can map a `GET` request to `yoursite.com/example` to the `index` method in the `app\Http\Controllers\ExampleController.php` file like this:

``` php
Route::get('example', 'ExampleController@index');
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

> Generate a controller with an [Artisan command](https://laravel.com/docs/artisan):
> ``` cli
> php artisan make:controller ExampleController
> ```

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

## Related Reading

- [Laravel Controllers][laravel-controllers]
- [Laravel Routes][laravel-routes]
- [Antlers](/antlers)

[laravel-controllers]: https://laravel.com/docs/controllers
[laravel-routes]: https://laravel.com/docs/routing
