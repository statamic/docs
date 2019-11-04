---
title: Navigation
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347202
id: 785ffa10-8b63-44b1-9da3-3837250cacbe
intro: The Control Panel navigation is quite customizable. You can add your own sections, pages, and subpages, as well as remove and modify existing ones.
---

Every nav item is represented by a `NavItem` object, which has a [full API](#the-navitem-class) for [adding](#adding-items), [removing](#removing-items), and [modifying](#modifying-items) items.  You may register your nav extensions in the `boot()` method of a service provider.

## Adding Items

Let's assume we're creating a Store addon, and want to add a `Store` nav item to the `Content` section of the navigation.  To add this item, we'll add the following code to our service provider's `boot()` method:

```php
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
    	->url('/store')
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
| `url()` | `$url` (string) | Define absolute URL. |
| `icon()` | `$icon` (string) | Define icon. |
| `children()` | `$children` (array\|collection\|closure) | Define child items. |
| `can()` | `$ability` (string), `$params` (mixed, optional) | Define authorization. |
| `active()` | `$pattern` (string) | Define active styling pattern. |
| `view()` | `$view` (string) | Define custom view. |

