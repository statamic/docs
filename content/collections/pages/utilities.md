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
        Utility::register('data_wangjangler')
            ->inertia('my-addon::DataWangjangler', fn ($request) => [
                'items' => Item::all(),
            ]);
    });
}
```

The first argument is the name of [an Inertia page component](/control-panel/css-javascript#inertia), and the second is an optional closure that returns props for the component.

You'll need to register the Inertia page using `Statamic.$inertia.register()`:

``` js
import DataWangjangler from './components/DataWangjangler.vue';

Statamic.booting(() => {
    Statamic.$inertia.register('my-addon::DataWangjangler', DataWangjangler);
});
```

Then create your Vue component:

``` vue
<script setup>
import { Head, router } from '@statamic/cms/inertia';

const props = defineProps({
    items: Array,
});

function wangjangle() {
    router.post(cp_url('utilities/data-wangjangler/process'));
}
</script>

<template>
    <Head title="Data Wangjangler" />

    <ui-header title="Data Wangjangler">
        <template #actions>
            <ui-button variant="primary" @click="wangjangle">
                Wangjangle that data
            </ui-button>
        </template>
    </ui-header>

    <ui-panel>
        <ul>
            <li v-for="item in items" :key="item.id">{{ item.name }}</li>
        </ul>
    </ui-panel>
</template>
```

:::tip
For help setting up Vite and Vue in your project, please see the [Vite Tooling](/addons/vite-tooling) (for addons) or [CSS & JavaScript](/control-panel/css-javascript#inertia) guides.
:::

## Customizing the navigation and card

You can customize the nav item, description, icon, and other details on the index listing by chaining the corresponding methods.

The `icon()` method accepts the name of an [icon included in Statamic](https://ui.statamic.dev/?path=/docs/components-icon--docs#available-icons), or an SVG string containing a custom icon (be sure to use `fill="currentColor"`):

``` php
use Statamic\Facades\Utility;

public function boot()
{
    Utility::extend(function () {
        Utility::register('data_wangjangler')
            ->inertia('my-addon::DataWangjangler')
            ->title('Data Wangjangler')
            ->navTitle('Wangjangler')
            // Icon included in Statamic
            ->icon('share-mega-phone')
            // Custom icon
            ->icon('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M246.0422 221.6193c-14.2079 -17.2455 -21.3609 -38.4104 -21.3609 -59.5753 0 -78.4865 94.0663 -156.875 188.1325 -156.875 51.9324 0 94.0662 42.1338 94.0662 94.0662 0 94.0662 -78.3885 188.1325 -156.973 188.1325 -21.1649 0 -42.3298 -7.153 -59.5753 -21.3609L58.6936 497.6449c-12.2482 12.2482 -32.1392 12.2482 -44.3875 0s-12.2482 -32.1393 0 -44.3875l231.7361 -231.6381Z" fill="currentColor" stroke-width="1"></path></svg>')
            ->description('Wanjangles your data at the click of a button.')
            ->docsUrl('https://yoursite.com/docs/wangjangler');
    });
}
```

## Using a custom controller

Instead of passing data to the utility in your service provider, you may define a custom controller instead.

``` php
Utility::register('data_wangjangler')
    ->action(WangjanglerController::class) // call the __invoke method
    ->action([WangjanglerController::class, 'index']); // call the index method
```

In your controller, you can do whatever you need to do, then return an Inertia.js Vue component:

``` php
use Inertia\Inertia;

class WangjanglerController
{
    public function __invoke()
    {
        $items = Item::all();

        return Inertia::render('my-addon::DataWangjangler', [
            'items' => $items,
        ]);
    }
}
```

Data will be passed to the component as props:

```vue
<script setup>
defineProps({
    items: Array,
});
</script>
```

## Routing

A route will be created for you automatically, using the slugified version of the handle you initially provided. eg. `/cp/utilities/data-wangjangler`

If your utility needs to _do_ something (like how you click a button in the cache manager utility to actually clear the cache), you may register additional routes.

``` php
Utility::register('data_wangjangler')->routes(function ($router) {
    $router->post('/', [WangjanglerController::class, 'process'])->name('process');
});
```

``` php
// WangjanglerController.php

public function process(Request $request)
{
    // Do the processing...

    return redirect()->back()->with('success', 'Data has been wangjangled!');
}
```

You can use the `cp_route` helper in PHP to generate URLs to your utility routes:

``` php
cp_route('utilities.data-wangjangler') // /cp/utilities/data-wangjangler
cp_route('utilities.data-wangjangler.process') // /cp/utilities/data-wangjangler/process
```

## Permissions

A single permission will be registered automatically using the handle.
eg. `access data_wangjangler utility`

Users without this permission will not see the utility in the navigation or utility listing.

## Using Blade

For simpler utilities, or if you prefer not to use Vue, you may build utilities using Blade, but there's a few limitations to be aware of:

- Blade-rendered pages trigger a full page reload rather than the SPA-style transitions used elsewhere in the Control Panel.
- Under the hood, Blade views are rendered inside a Vue component, which means `<script>` tags are not supported within your views.

To use a Blade view instead of an Inertia component, call the `->view()` method when creating your utility:

``` php
use Statamic\Facades\Utility;

public function boot()
{
    Utility::extend(function () {
        Utility::register('data_wangjangler')
            ->inertia('my-addon::DataWangjangler', fn ($request) => [ // [tl! --]
            ->view('wangjangler', fn ($request) => [ // [tl! ++]
                'items' => Item::all(),
            ]);
    });
}
```

Alternatively, when using a custom controller, you may use the `view()` helper instead of `Inertia::render()`.

Your Blade view doesn't need to extend a layout, Statamic will handle wrapping it automatically:

``` blade
<ui-header title="Data Wangjangler" />

<ui-panel>
    <ul>
        @foreach ($items as $item)
            <li>{{ $item->name }}</li>
        @endforeach
    </ul>
</ui-panel>
```
