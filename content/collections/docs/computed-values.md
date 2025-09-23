---
title: 'Computed Values'
blueprint: page
intro: 'Define dynamic values on your data and display them as virtual fields in the Control Panel. They''re like accessors on Eloquent models.'
id: 0327afd5-469b-4119-a75e-2bfe9389eb05
---
## Overview

Think of computed values as virtual fields that can be composed from any source. You could be grabbing a value from a secondary local database, a 3rd party API, or even by composing a dynamic value from other fields on the entry itself.

## Setting computed values

Inside a service provider's `boot` method, you can configure dynamic computed field data on [Collections](/collections) and [Users](/users) using the provided `computed()` helper on the relevant Facade.

### On user instances

For example, maybe you wish to return a user's `balance` using a 3rd party invoicing API:

```php
use Statamic\Facades\User;

User::computed('balance', function ($user, $value) {
    return InvoicingService::balance($user->email());
});
```

### On entry instances

Or maybe you wish to return a `shares` count on entries within your `articles` collection using a 3rd party social media API:

```php
use Statamic\Facades\Collection;

Collection::computed('articles', 'shares', function ($entry, $value) {
    return TooterService::shareCount($entry->permalink);
});
```

If you want to use the same computed value across multiple collections, you may provide an array of collections instead:

```php
use Statamic\Facades\Collection;

Collection::computed(['articles', 'pages'], 'shares', function ($entry, $value) {
    return TooterService::shareCount($entry->permalink);
});
```

You can also provide multiple computed values for the same collection using an associative array:

```php
Collection::computed('articles', [
    'shares' => function ($entry, $value) {
        return TooterService::shareCount($entry->permalink);
    },
    'likes' => function ($entry, $value) {
        return TooterService::likeCount($entry->permalink);
    },
]);
```

### Overriding using stored values

The second `$value` parameter in the `computed()` callback function will return a _stored_ value under the same handle, if one exists, allowing you to override computed values if necessary.

For example, maybe you wish to display an article's `subtitle` if one is saved on the entry, otherwise fall back to a truncated version of the entry's `description` value:

```php
use Statamic\Facades\Collection;
use Statamic\Support\Str;

Collection::computed('articles', 'subtitle', function ($entry, $value) {
    return $value ?? Str::limit($entry->value('description'), 25);
});
```

### Performance

If you plan on accessing data through a 3rd party API, or even computing values across large data sets locally, it may be beneficial to cache your data.

:::tip
You can use Laravel's [Cache](https://laravel.com/docs/cache#cache-usage) facade to store and retrieve cached values within your computed callback function.
:::

## Getting computed values

Once configured, you can simply access your computed values as properties on your instances (ie. `$user->balance` or `$entry->shares`).

:::tip
Computed values are only available for **top-level** fields. You can't use them inside Replicator or Grid fields. Likewise, computed values can't be queried as they're only evaluated after the query has been executed.
:::

### Showing computed values in the control panel

Or view your computed values in the control panel if you configure your blueprint to allow for it. The first step is to add a field with your computed value's `handle`:

<figure>
    <img src="/img/computed-field-handle.png" alt="Computed field handle">
</figure>

Next, set your field `Visibility` to `Computed`. This will ensure your field is displayed on your Publish Form as a read-only field [that will not store any data on save](/fields#field-data-flow):

<figure>
    <img src="/img/computed-field-visibility.png" alt="Computed field visibility config">
</figure>

You may also show this field as a column on your listings using the `Listable` setting, as shown above:

<figure>
    <img src="/img/computed-field-listing.png" alt="Computed field visibility config">
    <figcaption>One of us never has credit card debt, but who's complaining?</figcaption>
</figure>
