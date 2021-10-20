---
title: Customizing CP Navigation
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347202
intro: The Control Panel navigation is quite customizable. You can add your own sections, pages, and subpages, as well as remove and modify existing ones.
stage: 1
id: 785ffa10-8b63-44b1-9da3-3837250cacbe
---

:::tip
This page refers to the Control Panel's side-bar navigation. Not to be confused with ["Navs"](/navigation), where you can create trees to be used for the front-end of your site.
:::

Every nav item is represented by a `NavItem` object, which has a [full API](#the-navitem-class) for [adding](#adding-items), [removing](#removing-items), and [modifying](#modifying-items) items.  You may register your nav extensions in the `boot()` method of a service provider.

## Adding Items

Let's assume we're creating a Store addon, and want to add a `Store` nav item to the `Content` section of the navigation.  To add this item, we'll add the following code to our service provider's `boot()` method:

```php
use Statamic\Facades\CP\Nav;

public function boot()
{
    Nav::extend(function ($nav) {
        $nav->content('Store')
            ->route('store.index')
            ->icon('shopping-cart');
    });
}
```

The `content()` method there is a [magic method](http://php.net/manual/en/language.oop5.magic.php), and the name of method defines the section name that will be used.  If we need to display special characters in our section name, we can `create()` the nav item and explicitly define the section name:

```php
Nav::extend(function ($nav) {
    $nav->create('Store')
        ->section('Jack & Sons Inc.')
        ->route('store.index')
        ->icon('shopping-cart');
});
```

If you wish to use a custom SVG or one from the [Streamline Icon Pack](https://streamlineicons.com/) that's not included in Statamic, you may pass the SVG icon to the `icon()` method, in place of an icon name.

```php
Nav::extend(function ($nav) {
    $nav->create('Store')
        ->section('Jack & Sons Inc.')
        ->route('store.index')
        ->icon('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.547 9.674l7.778 7.778a4.363 4.363 0 0 0 .9-4.435l5.965-5.964.177.176a1.25 1.25 0 0 0 1.768-1.767l-4.6-4.6a1.25 1.25 0 0 0-1.765 1.771l.177.177-5.965 5.965a4.366 4.366 0 0 0-4.435.899zM10.436 13.563L.5 23.499" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>');
});
```

:::tip
Note that the `Nav` facade is `Statamic\Facades\CP\Nav`.

There's another Nav facade _without_ the CP namespace, and it's for the front-end ["Navs"](/navigation) feature.
:::

## Adding Children

Maybe we have `Products` and `Orders`, which we want to display as children under the `Store` item.  To do this, we'll add a `children()` call to the parent nav item:

```php
Nav::extend(function ($nav) {
    $nav->content('Store')
        ->route('store.index')
        ->icon('shopping-cart')
        ->children([
            'Products' => cp_route('store.products.index'),
            'Orders' => cp_route('store.orders.index')
        ]);
});
```

If we need to customize our child items further, we can use object notation.  For example, maybe we would like to authorize whether the user `can()` see these nav items:

```php
Nav::extend(function ($nav) {
    $nav->content('Store')
        ->route('store.index')
        ->icon('shopping-cart')
        ->can('view store')
        ->children([
            $nav->item('Products')->route('store.products.index')->can('view products'),
            $nav->item('Orders')->route('store.orders.index')->can('view orders')
        ]);
});
```

We can also defer the creation of children until render time by passing a closure.  For example, if we're dynamically hitting a data store to generate our children, we can use a closure to avoid the performance hit unless the navigation actually needs to render the children:

```php
Nav::extend(function ($nav) {
    $nav->content('Store')
        ->url('store')
        ->icon('shopping-cart')
        ->children(function () {
            return ProductType::hasPublished()->get()->map(function ($type) {
                return Nav::item($type->name)->url($type->url);
            });
        });
});
```

## Removing Items

To remove an item, we only need to specify the section and item name:

```php
Nav::extend(function ($nav) {
    $nav->remove('Content', 'Store');
});
```

To remove an entire section, we only need to specify the section name:

```php
Nav::extend(function ($nav) {
    $nav->remove('Content');
});
```

## Modifying Items

We can access any existing item using the same syntax as described above [when adding items](#adding-items).  We can even modify native Statamic nav items.  For example, maybe we wish to change the icon for the `Collections` item in the `Content` section of the nav:

```php
Nav::extend(function ($nav) {
    $nav->content('Collections')
        ->icon('coins');
});
```

The `content()` method there is a [magic method](http://php.net/manual/en/language.oop5.magic.php), which performs a `findOrCreate()` under the hood.  If the nav item is found, we can then chain on any modifications to be applied to the item.  If our section name contains any special characters, we can perform an explicit `findOrCreate()`:

```php
Nav::extend(function ($nav) {
    $nav->findOrCreate('Jack & Sons Inc.', 'Store')
        ->icon('coins');
});
```

## The NavItem Class

Each item you see in the navigation is an instance of the `Statamic\CP\Navigation\NavItem` class. Each top level instance within a section may contain its own collection of `NavItem` children.

### Basic API

The code examples above demonstrate how to [add](#adding-items), [modify](#modifying-items), and [remove](#removing-items) `NavItem` objects.  Once you have a `NavItem` object, the following chainable methods are available to you:

| Method | Parameters | Description |
| :--- | :--- | :--- |
| `name()` | `$name` (string) | Define item name. |
| `section()` | `$section` (string) | Define section name. |
| `route()` | `$name` (string), `$params` (mixed, optional) | Define a route automatically prefixing with `statamic.cp.` |
| `url()` | `$url` (string) | Define a URL instead of a route. A string without a leading slash will be relative from the CP. A leading slash will be relative from the root. You may provide an absolute URL. |
| `icon()` | `$icon` (string) | Define icon. |
| `children()` | `$children` (array\|collection\|closure) | Define child items. |
| `can()` | `$ability` (string), `$params` (mixed, optional) | Define authorization. |
| `view()` | `$view` (string) | Define custom view. |
| `active()` | `$pattern` (string) | A regular expression to check if the nav item is active. The URL will be relative from the CP. eg. on `/cp/foo`, you'd just get `foo`. |

