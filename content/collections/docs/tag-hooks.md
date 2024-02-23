---
id: 900414a8-f73a-46f0-82bd-b607767f5d5d
blueprint: page
title: 'Tag Hooks'
intro: 'Statamic allows you to hook into specific points in tag logic and perform operations using Pipelines.'
---
## About

Closures may be registered allowing you to "hook" into a specific point in a tag's lifecycle. These closures are added to a pipeline.

At that point in the tag, a payload is send through the pipeline, allowing any registered closures to inspect or modify the payload, then finally gets sent back to the tag.

## How to use hooks

For example, the `collection` tag will query for entries, then run the `fetched-entries` hook, passing all the entries along. Your hook may modify these entries.

```php
use Statamic\Tags\Collection;

Collection::addHook('fetched-entries', function ($entries, $next) {
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

The closure is scoped to the tag. The `$this` variable will be the tag class itself, and will act as if you're in the class so you can call protected methods, as well as any macroed methods.

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
