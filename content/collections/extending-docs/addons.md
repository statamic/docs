---
title: Addons
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569264134
id: 5bd75435-806e-458b-872e-7528f24df7e6
intro: An addon is a composer package that you intend to reuse, distribute, or sell. For simple or private packages, consider implementing directly into your Laravel application.
---

## Creating an addon

Eventually, an addon will be available on Packagist and installable through Composer (and therefore live inside your `vendor` directory).
During development however, you can keep it somewhere on your local filesystem and require it in your composer.json as a path repository.

> If you don't plan on distributing your addon, you may be fine with [application code](/extending).

An addon consists of at least a `composer.json` and a service provider. Your directory may be placed anywhere, but for the sake of this example, we'll put it in `addons/example`

``` files
/
|-- addons/
|   `-- example/
|       |-- src/
|       |   `-- ServiceProvider.php
|       `-- composer.json
|-- app/
|-- public/
`-- composer.json
```

``` json
{
    "name": "acme/example",
    "description": "Example Addon",
    "type": "statamic-addon",
    "autoload": {
        "psr-4": {
            "Acme\\Example\\": "src"
        }
    },
    "authors": [
        {
            "name": "Jason Varga"
        }
    ],
    "support": {
        "email": "support@statamic.com"
    },
    "extra": {
        "statamic": {
            "name": "Example",
            "description": "Example addon"
        },
        "laravel": {
            "providers": [
                "Acme\\Example\\ServiceProvider"
            ]
        }
    }
}
```

Note that the service provider should extend `Statamic\Providers\AddonServiceProvider`, and not Illuminate\Support\ServiceProvider which you might be used to if you come from a Laravel background. The Statamic subclass provides you with some helpers to reduce boilerplate.

``` php
<?php

namespace Acme\Example;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    //
}
```

In your project root's `composer.json`, add your package to the `require` and `repositories` sections, like so:

``` json
{
    ...

    "require": {
        ...,
        "acme/example": "*"
    },

    ...

    "repositories": [
        {
            "type": "path",
            "url": "addons/example"
        }
    ]
```

Run composer update from your _project root_ (not your addon directory).

``` bash
composer update
```

If you've been following correctly, you should see these two lines amongst a bunch of others.

```
Discovered Package: acme/example
Discovered Addon: acme/example
```

Your addon is now installed. You should be able to go to `/cp/addons` and see it listed.


## Installing an addon

### Public addons

A public addon is one that is available as a composer package on packagist.org. Simple require it with composer:

``` bash
composer require vendor/package
```

After the composer package has been brought in, Statamic will automatically activate it and publish its assets.

### Private addons

A private addon is one that isn't on packagist.org. You will need to use a composer path repository.

Download the package to a directory of your choosing.

In your project root's `composer.json`, add the package to the `require` and `repositories` sections, like so:

``` json
{
    ...

    "require": {
        ...,
        "acme/example": "*"
    },

    ...

    "repositories": [
        {
            "type": "path",
            "url": "addons/example"
        }
    ]
```

Run composer update from your project root:

``` bash
composer update
```

After the composer package has been brought in, Statamic will automatically activate it and publish its assets.


## Registering Components

You may register your various addon components by adding their class names to corresponding arrays:

``` php
protected $tags = [
    \Acme\Example\Tags\First::class,
    \Acme\Example\Tags\Second::class,
    // etc...
];

protected $modifiers = [
    //
];

protected $fieldtypes = [
    //
];

protected $widgets = [
    //
];

protected $commands = [
    //
];

```

## Assets

### CSS and Javascript

In your service provider, you may register any number of stylesheets or scripts by providing their full paths.

``` php
protected $scripts = [
    __DIR__.'/resources/js/example.js'
];

protected $stylesheets = [
    __DIR__.'/resources/css/example.css'
];
```

This will do two things:
- Statamic will load the respective files in the Control Panel. It will assume they exist in `public/vendor/[vendor]/[package].js` and `css` directories.
- Mark the file for publishing when the `artisan vendor:publish` command is used.

``` bash
php artisan vendor:publish --provider=YourServiceProvider --force
```

When an end user installs or updates your addon, the `vendor:publish` command will automatically be run behind the scenes for them.

> During development of your addon, rather than constantly running `vendor:publish`, consider symlinking your directory:
>
> ``` bash
> ln -s /path/to/addons/example/resources public/vendor/example/package
> ```

### Publishables

You may also mark generic assets for publishing by providing a `publishables` array with the full path to the  origin and the destination directory.

``` php
protected $publishables = [
    ___DIR__.'/resources/images' => 'images',
];
```

## Routing

### Registering Routes

You may register three types of routes in your service provider.

``` php
protected $routes = [
    'cp' => __DIR__.'/routes/cp.php',
    'actions' => __DIR__.'/routes/actions.php',
    'web' => __DIR__.'/routes/web.php',
];
```

#### Control Panel Routes

Control Panel routes will be prefixed by `/cp` (or whatever the cp route has been configure) and will have authorization automatically applied.

We recommend that you prefix your routes with your addon's name, but we've purposely left it off to give you more flexibility.

#### Action Routes

Action routes will be prefixed by `/!/addon-name` and are generally intended as front-end "actions" that your addon
may expose without being a prominent section of the website. For example, somewhere to process a form submission.

#### Web Routes

Web routes have no prefix and no middleware attached. They will be added at the root level, as if you were adding them to a standard
Laravel app's `routes/web.php` file, giving you complete control.

### Writing Routes

When referencing a controller in a route, it will automatically be namespaced to your addon's root namespace.

``` json
"autoload": {
    "psr-4": {
        "Acme\\Example\\": "src"
    }
},
```

``` php
Route::get('/', 'ExampleController@index'); // Acme\Example\ExampleController
```

If you'd prefer not to have separate route files, you can write routes into a closure directly in your service provider's `boot` method.

``` php
public function boot()
{
    parent::boot();

    $this->registerCpRoutes(function () {
        Route::get(...);
    });

    $this->registerWebRoutes(function () {
        Route::get(...);
    });

    $this->registerActionRoutes(function () {
        Route::get(...);
    });
}
```

Other than that, you're free to write routes [as per any Laravel application](https://laravel.com/docs/5.6/routing).

## Middleware

You may push your own middleware onto two separate stacks which correspond to two of the [route groups](#routing) listed above.

``` php
protected $middleware = [
    'cp' => [
        YourCpMiddleware::class,
        AnotherCpMiddleware::class
    ],
    'web' => [
        YourWebMiddleware::class
    ],
];
```

## Events

You may register any number of event listeners or subscribers the same way you would in a traditional Laravel application's EventServiceProvider – by using a `$listen` or `$subscribes` array:

``` php
protected $listen = [
    'Acme\Example\Events\OrderShipped' => [
        'Acme\Example\Listeners\SendShipmentNotification',
    ],
];

protected $subscribe = [
    'Acme\Example\Listeners\UserEventSubscriber',
];
```

Consult the [Laravel event documentation]() to learn how to define events, listeners, and subscribers.


## Scheduling

To define a schedule from your addon, you can add a `schedule` method just like you would typically see in a Laravel application's App\Console\Kernel class.

``` php
protected function schedule($schedule)
{
    $schedule->command('something')->daily();
}
```

Consult the [Laravel scheduling documentation]() to learn how to define your schedule.
