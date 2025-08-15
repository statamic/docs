---
id: 900414a8-f73a-46f0-82bd-b607767f5d5d
blueprint: page
title: 'Hooks'
intro: 'Statamic allows you to hook into specific points in PHP logic and perform operations using Pipelines.'
---
:::warning
This page is about PHP-based hooks. We also have [JavaScript-based hooks](/extending/js-hooks), which work differently.
:::

## About

Closures may be registered allowing you to "hook" into a specific point in PHP's lifecycle. These closures are added to a pipeline.

Hooks may be located in tags, fieldtypes, and so on.

At some point, a payload is send through the pipeline, allowing any registered closures to inspect or modify the payload, then finally gets sent back to the origin.

## How to use hooks

For example, the `collection` tag will query for entries, then run the `fetched-entries` hook, passing all the entries along. Your hook may modify these entries.

```php
// app/Providers/AppServiceProvider.php

use Statamic\Tags\Collection;

Collection::hook('fetched-entries', function ($entries, $next) {
    // Modify the entries...
    $modified = $entries->take(3);

    // Pass them along to the next registered closure.
    return $next($modified);
});
```

It's also possible to wait until all the other closures in the pipeline have completed. To do that, pass it along to the next closure _first_.

For example, maybe you need to get all the ids of the entries that will be output. By passing along to the other closures first, it will give them a chance to manipulate it. In the example above, it would take the first 3 entries. Now in this hook we'll be getting 3 ids rather than the full amount the tag was originally going to output.

```php
// app/Providers/AppServiceProvider.php

use Statamic\Tags\Collection;

Collection::addHook('fetched-entries', function ($entries, $next) {
    // Pass the payload along to the next registered closures.
    $entries = $next($entries);

    $ids = $entries->pluck('id');

    // You'll still need to return it!
    return $entries;
});
```

### Scope

The closure is scoped to the class where the hook was triggered. The `$this` variable will be the class itself, and will act as if you're in the class so you can call protected methods, as well as any macroed methods.

```php
Tag::addHook('name', function ($payload, $next) {
    // {{ tag foo="bar" }}
    $this->params->get('foo'); // bar
});
```


## Available hooks

### All tags: `init`
Triggered after the tag has been initialized. The payload is `null`.

### Collection tag: `fetched-entries`
Triggered just after completing the query.
The payload will either be an `EntryCollection` or a `Paginator`, depending on whether the `paginate` parameter was used.

### Form tag: `attrs`
Triggered when building the opening form tag. The payload is an array containing two properties:
- 'attrs' - an array containing the currently calculated list of attributes for the opening &lt;form&gt; tag. Modifications to this array will affect the rendered form tag - e.g. it can be used to add attributes to the form tag.
- 'data' - the data assembled about the form (config, blueprint, sections etc.)

### Form tag: `after-open`
Triggered immediately after the opening form tag. The payload is an array containing two properties:
- 'html' - A string containing the rendered markup of the form so far. Modifications to this string will affect the final rendered markup.
- 'data' - the data assembled about the form (config, blueprint, sections etc.)

### Form tag: `before-open`
Triggered immediately before the closing form tag. The payload is an array containing two properties:
- 'html' - A string containing the rendered markup of the form so far. Modifications to this string will affect the final rendered markup.
- 'data' - the data assembled about the form (config, blueprint, sections etc.)

### Augmentation: `augmented`
Triggered when a new augmented instance is made.
The payload will be the object being augmented (eg. `Entry` / `Term`).

### Entry Index Query: `query`
Triggered before the index query for the Entries listing table is executed.
The payload will be an object with `query` and `collection` properties.

```php
use Statamic\Hooks\CP\EntriesIndexQuery;

EntriesIndexQuery::hook('query', function ($payload, $next) {
    $payload->query; // a QueryBuilder instance
    $payload->collection; // a Collection instance

    return $next($payload);
});
```

### Bard: `augment`
Triggered while the Bard fieldtype is being augmented.
The payload will be an array of the Bard's content.

### Bard: `process`
Triggered when the `process` method is called on the Bard fieldtype (when saving a Bard field in the Control Panel).
The payload will be an array of the Bard's content.

### Bard: `pre-process`
Triggered when the `preProcess` method is called on the Bard fieldtype (when preparing the Bard field for the publish form).
The payload will be an array of the Bard's content.

### Bard: `pre-process-index`
Triggered when the `preProcessIndex` method is called on the Bard fieldtype (when preparing the Bard field for a listing column).
The payload will be an array of the Bard's content.

### Bard: `pre-process-validatable`
Triggered when the `preProcessValidatable` method is called on the Bard fieldtype (when preparing the field for validation).
The payload will be an array of the Bard's content.

### Bard: `preload`
Triggered when the `preload` method is called on the Bard fieldtype (when preparing the `meta` prop for the publish form).
The payload will be an array of the Bard's content.

### Bard: `extra-rules`
Triggered when the `extraRules` method is called on the Bard fieldtype (when gathering validation rules).
The payload will be an array of the Bard's content.

### Bard: `extra-validation-attributes`
Triggered when the `extraValidationAttributes` method is called on the Bard fieldtype (when gathering validation attributes).
The payload will be an array of the Bard's content.

### Static Cache Warming: `additional`
Triggered when the `static:warm` command is run. This hook allows you to warm additional URIs during the static warming process.
For more information about this hook, see the docs on [Static Caching](/static-caching#warming-additional-urls).

### Multisite Command: `after`
Triggered at the end of the `multisite` command. This hook allows you to run code when an app is being converted from a single-site to a multi-site.
The payload is `null`.


## Triggering your own hooks

You may want to trigger your own hook pipeline so that others may use it.

To do this, you may use the `runHooks` method from the `Hookable` trait, passing the hook name and a payload.
Once any hook closures have finished running, the payload will be returned back from it.

```php
use Statamic\Support\Traits\Hookable;

class YourClass
{
    use Hookable;

    public function something()
    {
        $result = $this->runHooks('hook-name', $payload);
    }
}
```

Now others will be able to call `hook` on your class to register their hook:

```php
YourClass::hook('hook-name', function ($payload, $next) {
    // ...
    return $next($payload);
});
```

:::tip
Tag classes already `use Hookable` so you can simply use `$this->runHooks()` without importing anything.
:::
