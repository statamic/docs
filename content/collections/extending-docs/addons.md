---
id: 5bd75435-806e-458b-872e-7528f24df7e6
blueprint: page
title: Addons
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569264134
intro: 'An addon is a composer package you intend to reuse, distribute, or sell. For simple or private packages, consider implementing directly into your Laravel application.'
stage: 1
---
## Creating an Addon

You can generate an addon with a console command:

``` shell
php please make:addon example/my-addon
```

This will scaffold out everything you need to get started as a [private addon](#private-addons) within your site's `addons` directory.

Eventually, an addon may be available on Packagist and installable through Composer (and therefore live inside your `vendor` directory). During development however, you can keep it on your local filesystem as a path repository.

:::tip
If you don't plan on distributing your addon or sharing it between multiple projects, you can take a simpler approach and just [add things to your Laravel application](/extending).
:::


### What's in an addon?

An addon consists of at least a `composer.json` and a service provider. Your directory may be placed anywhere, but for the sake of this example, we'll put it in `addons/acme/example`

``` files theme:serendipity-light
addons/
    acme/
        example/
            src/
                ServiceProvider.php
            composer.json
app/
content/
config/
public/
    index.php
resources
composer.json
```

### Composer.json

The composer.json is used by (you guessed it) Composer in order to install your package.

The `extra.statamic` section is used by Statamic to know that it's an addon and not just a standard Composer package.
The `extra.laravel.providers` section what Laravel uses to load your service provider.

``` json
{
    "name": "acme/example",
    "description": "Example Addon",
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

### Service Provider

The service provider is where all the various components of your addon get wired together.

You should make sure that your service provider extends Statamic's `Statamic\Providers\AddonServiceProvider`, and not `Illuminate\Support\ServiceProvider`. Statamic's `AddonServiceProvider` includes some bootstrapping and autoloading that isn't included with Laravel's service provider.

``` php
<?php

namespace Acme\Example;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    //
}
```

:::tip
The `bootAddon` method should be used instead of `boot`. They are the same except that it
makes sure to boot _after_ Statamic has booted.
:::

### Installing your freshly created addon

If you ran the `make:addon` command, this would have been taken care of for you. 

Otherwise, in your project root's `composer.json`, add your package to the `require` and `repositories` sections, like so:

``` json
{
    "require": {
        "acme/example": "*"
    },
    "repositories": [
        {
            "type": "path",
            "url": "addons/example"
        }
    ]
```

Run composer update from your _project root_ (not your addon directory).

``` shell
composer update
```

If you've been following correctly, you should see these two lines amongst a bunch of others.

```
Discovered Package: acme/example
Discovered Addon: acme/example
```

Your addon is now installed. You should be able to go to `/cp/addons` and see it listed.


## Installing an Addon

### Public addons

A public addon is one available as a composer package on packagist.org. Simply require it with composer:

``` shell
composer require vendor/package
```

### Private addons

A private addon is one _not_ on packagist.org. You will need to use a composer path repository.

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

``` shell
composer update
```

After the composer package has been brought in, Statamic will automatically activate it and [publish its assets](#publishing-assets).

### Post-install commands {#post-install-commands}

By default the `vendor:publish` command will be run for you after `statamic:install`, letting your assets be automatically published.

However, you can run other commands or custom code too using the `afterInstalled` method:

``` php
public function bootAddon()
{
    Statamic::afterInstalled(function ($command) {
        $command->call('some:command');
    });
}
```


## Registering Components

::: tip
Statamic v5.28.0 and v5.29.0 introduced the concept of "autoloading" for most addon components.

For example: as long as your tags live in `src/Tags` and your fieldtypes live in `src/Fieldtypes`, they will be automatically registered by Statamic, without you needing to register them manually.

If your addon supports Statamic v5.28.0 or lower, you should continue registering components manually, like shown below. Otherwise, you can let Statamic do its thing 😎.
:::

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
The method of adding assets will differ slightly depending on whether you are using Vite or another build process. We recommend Vite.

#### Using Vite (recommended) {#using-vite}

In your service provider, you may register your Vite config like this, adjusting the paths appropriately.

``` php
protected $vite = [
    'input' => [
        'resources/js/cp.js',
        'resources/css/cp.css'
    ],
    'publicDirectory' => 'resources/dist',
];
```

[Get more in-depth about how to use Vite in your addon](/extending/vite-in-addons)

#### Using Webpack/Mix

In your service provider, you may register any number of stylesheets or scripts by providing their full paths.

``` php
protected $scripts = [
    __DIR__.'/../resources/js/example.js'
];

protected $stylesheets = [
    __DIR__.'/../resources/css/example.css'
];
```

Statamic will load the respective files in the Control Panel. It will assume they exist in `public/vendor/[vendor]/[package].js` and `css` directories.

### Publishables

You may also mark generic assets for publishing by providing a `publishables` array with the full path to the  origin and the destination directory.

``` php
protected $publishables = [
    __DIR__.'/../resources/images' => 'images',
];
```

### Publishing assets

When using the `$vite`, `$scripts`, `$stylesheets`, and `$publishables` properties, these files will be made available to the `artisan vendor:publish` command.
They will all be tagged using your addon's slug.

Whenever the `statamic:install` command is run (i.e. after running `composer update`, etc) the following command will be run:

``` shell
php artisan vendor:publish --tag=your-addon-slug --force
```

You can prevent these from being automatically published by adding a property to your provider:

``` php
protected $publishAfterInstall = false;
```

This may be useful if you need more control around groups of assets to be published, or if you're using custom [post-install commands](#post-install-commands).

### Assets during development

During development, if you're using Vite, the assets will be loaded through a Vite server and should "just work".

If you're using Webpack/Mix, rather than constantly running `vendor:publish`, consider symlinking your addon's `resource` directory:

``` shell
ln -s /path/to/addons/example/resources public/vendor/package
```

## Routing

### Registering Routes

You may register three types of routes in your service provider.

``` php
protected $routes = [
    'cp' => __DIR__.'/../routes/cp.php',
    'actions' => __DIR__.'/../routes/actions.php',
    'web' => __DIR__.'/../routes/web.php',
];
```

::: tip
As of Statamic v5.29.0, addon routes following the convention shown above will be automatically registered by Statamic.

If your addon supports Statamic v5.29 or lower, you should continue registering your route files manually, like shown below. Otherwise, you can let Statamic do its thing 😎.
:::

#### Control Panel Routes

Control Panel routes will be automatically prefixed by `/cp` (or whatever URL the control panel has been configured to use) and will have authorization applied.

We recommend prefixing routes with your addon's name but we didn't enforce this explicitly to give you a bit more flexibility.

#### Action Routes

Action routes will be prefixed by `/!/addon-name` and are generally intended as front-end "actions" your addon may expose without being a prominent section of the website. For example, somewhere to process a form submission.

#### Web Routes

Web routes have no prefix and no Statamic middleware attached. They will be added at the root level, as if you were adding them to a standard Laravel app's `routes/web.php` file, giving you complete control. However, as a Laravel route, they will have the `web` middleware attached.

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

If you'd prefer not to have separate route files, you can write routes in your service provider's `bootAddon` method.

``` php
public function bootAddon()
{
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

Other than that, you're free to write routes [as per any Laravel application](https://laravel.com/docs/routing).

### Route Model Binding

Statamic uses [route model binding](https://laravel.com/docs/routing#route-model-binding) to automatically convert some route parameters into usable objects.

Words aligning with core Statamic concepts will automatically be converted to their appropriate objects: `collection`, `entry`, `taxonomy`, `term`, `asset_container`, `asset` ,`global`, `site`, `revision`, `form`, and `user`

You're free to use these words as your route parameters, but be aware they will automatically attempt to convert to the respective objects. For example:

``` php
public function example(Request $request, $entry)
{
    // Given a route of "/example/{entry}", when visiting "/example/123"
    // $entry will be an Entry object with an ID of 123.
    // There will be a 404 if an entry with an ID of 123 doesn't exist.
}
```

## Middleware

You may push your own middleware onto respective middleware groups using the `$middlewareGroups` property.
The keys are the names of the groups, and the values are arrays of middleware classes to be applied.

``` php
protected $middlewareGroups = [
    'statamic.cp.authenticated' => [
        YourCpMiddleware::class,
        AnotherCpMiddleware::class
    ],
    'web' => [
        YourWebMiddleware::class
    ],
];
```

Available middleware groups are:

| Group | Description |
|-------|-------------|
| `web` | Front-end web requests, defined in the project's `App\Http\Kernel` class.
| `statamic.web` | Statamic-specific front-end web requests. This includes routes that correspond to content (like entries), as well as manually defined routes using `Route::statamic()`. These will also have `web` middleware applied.
| `statamic.cp` | All control panel requests (even ones not protected by authentication, like the login page).
| `statamic.cp.authenticated` | Control panel routes behind authentication. Anything in there can assume there will be an authenticated user available. These will also have the `statamic.cp` middleware applied.

## Views

Any views located in your `resources/views` directory will automatically be available to use in your code using your package name as the namespace.

``` files theme:serendipity-light
/
    src/
    resources/
        views/
            foo.blade.php
```

``` php
// assuming your package is named vendor/my-addon
return view('my-addon::foo');
```

If you want to customize the namespace, you can set the `$viewNamespace` property on your provider:

``` php
protected $viewNamespace = 'custom';
```
``` php
return view('custom::foo');
```

## Events

::: tip
Statamic v5.35.0 introduced the concept of "autoloading" for event listeners.

As long as your event listener lives in `src/Listeners` and the event is typehinted in the listener's `handle` or `__invoke` method, they will be automatically registered by Statamic, without you needing to register them manually.

Subscribers will also be autoloaded, as long as they live in `src/Subscribers`.

If your addon supports below Statamic v5.33.0, you should continue registering events and subscribers manually, like shown below. Otherwise, you can let Statamic do its thing 😎.
:::

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

Consult the [Laravel event documentation](https://laravel.com/docs/events) to learn how to define events, listeners, and subscribers.


## Scheduling

To define a schedule from your addon, you can add a `schedule` method just like you would typically see in a Laravel application's App\Console\Kernel class.

``` php
protected function schedule($schedule)
{
    $schedule->command('something')->daily();
}
```

Consult the [Laravel scheduling documentation](https://laravel.com/docs/scheduling#defining-schedules) to learn how to define your schedule.

## Editions

An addon can have various editions which enable you to limit your features depending on which is selected.

For example, you could have a free edition with limited features, and an edition with extra features that requires a license.

### Defining Editions

You can define your editions in your `composer.json`. They should match the edition handles that you set up on the Marketplace.

``` json
{
    "extra": {
        "statamic": {
            "editions": ["free", "pro"]
        }
    }
}
```

:::best-practice
The first edition is the default when a user hasn't explicitly selected one. Your editions should be listed from least to most expensive because that's the nice thing to do.
:::

### Feature Toggles

You can check for the configured edition in order to toggle features.

``` php
$addon = Addon::get('vendor/package');

if ($addon->edition() === 'pro') {
    //
}
```

:::tip
You don't need to check whether a license is valid, Statamic does that automatically for you.
:::


## Update Scripts

You may register update scripts to help your users migrate data, etc. when new features are added or breaking changes are introduced.

For example, maybe you've added a new permission and want to automatically give all of your existing form admins that new permission. To do this, first register your update script in your addon's service provider:

``` php
protected $updateScripts = [
    \Acme\Example\Updates\UpdatePermissions::class,
];
```

Then in your update script, you can extend `UpdateScript` and implement the necessary methods:

``` php
use Statamic\UpdateScripts\UpdateScript;

class UpdatePermissions extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('1.2.0');
    }

    public function update()
    {
        Role::all()->each(function ($role) {
            if ($role->hasPermission('configure forms')) {
                $role->addPermission('configure goat-survey-pro')->save();
            }
        });

        $this->console()->info('Permissions added successfully!');
    }
}
```

The `shouldUpdate()` method helps Statamic determine when to run the update script. Feel free to use the `isUpdatingTo()` helper method, or the provided `$newVersion` and `$oldVersion` variables to help you write this logic.

The `update()` method is where your custom data migration logic happens. Feel free to use the `console()` helper to output to the user's console as well. In the above example, we assign the new `configure goat-survey-pro` permission to all users who have the `configure forms` permission.

That's it! Statamic should now automatically run your update script as your users update their addons.

## Testing

Statamic automatically scaffolds a PHPUnit test suite when you generate an addon with `php please make:addon`.

To learn more about writing addon tests, please review our [Testing in Addons](/extending/testing-in-addons) guide.

## Publishing to the Marketplace

Once your addon is ready to be shared, you can publish it on the [Statamic Marketplace](https://statamic.com/marketplace) where it can be discovered by others.

Before you can publish your addon, you'll need a couple of things:

- Publish your Composer package on [packagist.org](https://packagist.org).
- Create a [statamic.com seller account](https://statamic.com/creator/begin)
- If you're planning to charge for your addons, you'll need to link connect your bank details to your seller account.

In your seller dashboard, you can create a product. There you'll be able to link your Composer package that you created on Packagist, choose a price, write a description, and so on.

Products will be marked as drafts that you can preview and tweak until you're ready to go.

Once published, you'll be able to see your addon on the Marketplace and within the Addons area of the Statamic Control Panel.


## Addons vs. Starter Kits

Both addons and starter kits can be used to extend the Statamic experience, but they have different strengths and use cases:

### Addons

- Addons are installed via `composer`, like any PHP package
- Addons live within your app's `vendor` folder after they are installed
- Addons can be updated over time
- Addon licenses are tied to your site

:::tip
An example use case is a custom fieldtype maintained by a third party vendor. Even though the addon is installed into your app, you still rely on the vendor to maintain and update the addon over time.
:::

### Starters Kits

- Starter kits are installed via `statamic new` or `php please starter-kit:install`
- Starter kits install pre-configured files and settings into your site
- Starter kits do not live as updatable packages within your apps
- Starter kit licenses are not tied to a specific site, and expire after a successful install

:::tip
An example use case is a frontend theme with sample content. This is the kind of thing you would install into your app once and modify to fit your own style. You would essentially own and maintain the installed files yourself.
:::
