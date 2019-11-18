---
title: Controllers
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568558701
id: 5e848460-9bbc-449e-8edd-182d918163ff
blueprint: page
---
Since Statamic is a package sitting inside of a regular Laravel application, you have the freedom to create your own routes.

Inside `routes/web.php`, you can [define routes](https://laravel.com/docs/6.x/routing).

> These will take precedence over any Statamic routing rules.

For example, a `GET` request to `yoursite.com/example` will load the `index` method in the `app\Http\Controllers\ExampleController.php` file:

``` php
Route::get('example', 'ExampleController@index');
```

In your controller, you can render views like you would in a regular app:

``` php
public function index()
{
    // ...

    return view('myview');  // resources/views/myview.blade.php
}
```

> Generate a controller with an Artisan command:
> ``` cli
> php artisan make:controller ExampleController
> ```

## Rendering Antlers views

Returning `view('myview')` _will_ render the `myview.antlers.html` view, however you won't automatically get the template-injected-into-a-layout behavior you'd normally expect.

To do that, you can return a `Statamic\View\View` instance:

``` php
public function index()
{
    return (new \Statamic\View\View)
        ->template('myview')
        ->layout('mylayout')
        ->with(['title' => 'The title']);
}
```

Now, `myview` will be injected into `mylayout`'s `template_content` variable.
Anything provided to `with` (eg. `title`) will be available in both views.