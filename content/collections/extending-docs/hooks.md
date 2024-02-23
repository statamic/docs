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


## Triggering your own hooks

You may want to trigger your own hook pipeline so that others may use it.

To do this, you may use the `runHooks` method from the `HasHooks` trait, passing the hook name and a payload.
Once any hook closures have finished running, the payload will be returned back from it.

```php
use Statamic\Extend\HasHooks;

class YourClass
{
    use HasHooks;

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
Tag classes already `use HasHooks` so you can simply use `$this->runHooks()` without importing anything.
:::
