---
title: Utilities
id: aa6e0a79-9d3f-493b-92c9-df4d2257bc64
intro: Utilities are simple tools with their own views, routes, navigation items, and permissions.
---
## What's a utility?

A utility is really just a route or two with a view, injected into the _Utilities_ area of the control panel,
and wrapped up with a permission. You _could_ make the same thing by wiring up the individual parts, but creating
a utility is a shortcut.

To get an idea for what a utility is, take a look at the utilities Statamic ships with:
- A page for viewing cache information and a button to clear it.
- A page to list PHP settings from `phpinfo()`.
- A page letting you clear search indexes.
- A page to view email configuration and send a test.

## Creating a utility

Registering a utility will give you a route, nav item, and a permission for free.

In a service provider's `boot` method, you can register a utility with the `Utility` facade.

Start with `Utility::register()` with the handle of the utility, then chain as many methods as you want.

Make sure to surround any utility registrations in a `Utility::extend` closure.

``` php
use Statamic\Facades\Utility;

public function boot()
{
    Utility::extend(function () {
        Utility::register('data_wangjangler')->view('wangjangler.utility');
    });
}
```

``` blade
@extends('statamic::layout')
@section('title', __('Data Wangjangler'))

@section('content')
    <div class="flex items-center justify-between">
        <h1>{{ __('Data Wangjangler') }}</h1>
    </div>

    <button @click="commenceWangjangling">
        Wangjangle that data.
    </button>
@stop
```

## Customizing the navigation and card

You can customize the nav item, description, icon, and other details on the index listing by chaining the corresponding methods.

For icons you can pass an SVG as a string. Be sure to use `fill="currentColor"` to allow the UI to fit into the control panel.

``` php
use Statamic\Facades\Utility;

public function boot()
{
    Utility::extend(function () {
        Utility::register('data_wangjangler')
            ->title('Data Wangjangler')
            ->navTitle('Wangjangler')
            ->icon('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M246.0422 221.6193c-14.2079 -17.2455 -21.3609 -38.4104 -21.3609 -59.5753 0 -78.4865 94.0663 -156.875 188.1325 -156.875 51.9324 0 94.0662 42.1338 94.0662 94.0662 0 94.0662 -78.3885 188.1325 -156.973 188.1325 -21.1649 0 -42.3298 -7.153 -59.5753 -21.3609L58.6936 497.6449c-12.2482 12.2482 -32.1392 12.2482 -44.3875 0s-12.2482 -32.1393 0 -44.3875l231.7361 -231.6381Z" fill="currentColor" stroke-width="1"></path></svg>')
            ->description('Wanjangles your data at the click of a button.')
            ->docsUrl('https://yoursite.com/docs/wangjangler');
    });
}
```

## Customizing the controller and view

At a minimum you need to tell it which view to load.

``` php
Utility::register('data_wangjangler')->view('wangjangler');
```

If you'd like to pass data to it, you could use a closure similar to if it were in a routes file:

``` php
Utility::register('data_wangjangler')->view('wangjangler', function ($request) {
    return ['foo' => 'bar'];
});
```

Or you can point to a controller action:

``` php
Utility::register('data_wangjangler')
    ->action(WangjanglerController::class) // call the __invoke method
    ->action([WangjanglerController::class, 'index']); // call the index method
```

## Routing

A route will be created for you automatically, using the slugified version of the handle you initially provided. eg. `/cp/utilities/data-wangjangler`

If your utility needs to _do_ something (like how you click a button in the cache manager utility to actually clear the cache)
you may register additional routes.

``` php
Utility::register('data_wangjangler')->routes(function ($router) {
    $router->post('/', [WangjanglerController::class, 'make'])->name('make');
});
```

``` blade
{{ cp_route('utilities.data-wangjangler.make') }}
// outputs: /cp/utilities/data-wangjangler/make
```

## Permissions

A single permission will be registered automatically using the handle.
eg. `access data_wangjangler utility`

Users without this permission will not see the utility in the navigation or utility listing.
