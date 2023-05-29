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

Start with `Utility::make()`, chain as many methods as you want, then finish with `Utility::register($utility)`. At a minimum, you'll need a view.
```php
use Statamic\Facades\Utility;

public function boot()
    {
        $utility = Utility::make('structure-fix')
            ->title('Fix structure tree')
            ->description('This will fix errors in structure tree.')
            ->action([UtilityController::class, 'structureInspect']);

        Utility::register($utility);
    }
```
Make sure to surround any utility registrations in a `Utility::extend` closure.

``` php
use Statamic\Facades\Utility;

public function boot()
{
    Utility::extend(function () {
        Utility::register('french-fries')->view('fries-utility');
    });
}
```

``` blade
@extends('statamic::layout')
@section('title', __('French Fries'))

@section('content')
    <div class="flex items-center justify-between">
        <h1>{{ __('French Fries') }}</h1>
    </div>

    <div class="mt-3 card">
        French Fries
    </div>
@stop
```

## Customizing the navigation and card

You can customize the nav item and the card within the listing by chaining additional methods.

``` php
$utility
    ->title('French Fries')
    ->navTitle('Fries')
    ->description('Makes french fries at the click of a button.')
    ->docsUrl('https://yoursite.com/docs/french-fries')
    ->register();
```

## Customizing the controller and view

At a minimum you need to tell it which view to load.

``` php
$utility->view('fries');
```

If you'd like to pass data to it, you could use a closure similar to if it were in a routes file:

``` php
$utility->view('fries', function ($request) {
    return ['foo' => 'bar'];
});
```

Or you can point to a controller action:

``` php
$utility
    ->action(FriesController::class) // call the __invoke method
    ->action([FriesController::class, 'index']); // call the index method
```

## Routing

A route will be created for you automatically, using the slugified version of the handle you initially provided. eg. `/cp/utilities/french-fries`

If your utility needs to _do_ something (like how you click a button in the cache manager utility to actually clear the cache)
you may register additional routes.

``` php
$utility->routes(function ($router) {
    $router->post('/', [FriesController::class, 'make'])->name('make');
});
```

``` blade
{{ cp_route('utilities.french-fries.make') }}
// outputs: /cp/utilities/french-fries/make
```

## Permissions

A single permission will be registered automatically using the handle.  
eg. `access french fries utility`

Users without this permission will not see the utility in the navigation or utility listing.
