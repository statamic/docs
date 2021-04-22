---
title: Stache
template: page
intro: >
    Statamic's data storage layer is affectionately named the "Stache". Think of it like Tom Selleck's face, if it were a flat-file database..
stage: 4
id: 499d808b-18be-42e9-acd0-91bcdff73193
---
## Overview

Rather than using a database as a storage layer, Statamic compiles the data in your content files into an efficient index-based system stored in Laravel's application cache. This stache can be rebuilt from scratch at any time. This is often done when content or settings change, or when updates are deployed to a production server.

<figure class='bg-mint'>
    <img src="/img/tom-selleck-lg.jpg" alt="Tom Selleck as Magnum P.I.">
    <figcaption>Behold, the stache of all staches!</figcaption>
</figure>

## File Changes

Since your data is coming from your content files, you're able to just open an entry's file in your text editor and see its changes reflected on your site immediately. Rad!

When you try to access an item, under the hood the Stache will watch for any modified files, and then update the corresponding indexes.

> This is great for local development, but on a production environment, it's a good idea to disable the file watcher. If you're editing content through the control panel, or only ever pushing content through deployments, you would be incurring extra overhead for no reason.
>
> You can disable this feature in `config/statamic/stache.php`.
>
> ``` php
> return [
>    'watcher' => false,
> ];
> ```

## Stores

The Stache is comprised of different stores responsible for fetching their own data sets.

For instance, if you wanted to get a `Collection` object, the `CollectionStore` would be in charge. It knows that any YAML file inside `content/collections` translates into one.

The following stores exist in the Stache:

- `taxonomies`
- `terms` (grouped by taxonomy)
- `collections`
- `entries` (grouped by collection)
- `collection-trees`
- `navigation`
- `nav-trees`
- `globals`
- `asset-containers`
- `assets`* (grouped by container)
- `users`

You're able to customize all the stores inside the Stache by referencing the keys above. You can change the directories for each of them. You can also change the class if you need to customize any of its logic.

```php
// config/statamic/stache.php
'stores' => [
    'entries' => [
        'class' => EntriesStore::class,
        'directory' => base_path('content/collections')
    ]
]
```

> If you only want to change the `directory`, you don't need to include the `class`.

\* The `assets` store cannot have its directory customized here. You configure its location through the [container](/assets#containers).

## Indexes

Each store will organize data from its items into indexes. It'll then use those to narrow down items when performing queries.

For instance, you will find an index of all entry titles, which might look like this:

``` txt
entry-id-1: Entry One
entry-id-2: Entry Two
```

### Default indexes

All stores will have a number of predefined indexes, like id and path. Some stores will have their own predefined indexes. eg. Entry stores will also have title, slug, uri, etc.

### When does indexing happen?

Indexes will only be created when needed, when a query is performed.

When saving an item, its corresponding values will be updated in each of its store's indexes.
eg. An entry's title will be inserted into the title index, its slug into the slug index, and so on.

When deleting, it will be removed from each index.

Indexes may be created in advance by running the following command:

``` cli
php please stache:warm
```

### Configuring additional indexes

Take this tag, for example:

```
{{ collection:blog awesome:is="true" }}
```

Under the hood, it would be doing `->where('awesome', true)`, which would look for the `awesome` index. If it didn't exist, it would create it right there.

Creating an index could take some time, depending on how much content you have.

If you know you will be needing these indexes in advance, you can add them to a store's configuration in `config/statamic/stache.php`:

``` php
return [
    'stores' => [
        // ...
        'entries' => [
            'class' => Stores\EntriesStore::class,
            'directory' => base_path('content/collections'),
            'indexes' => [
                'awesome',
            ]
        ],
        // ...
    ],
]
```

Or, add it to all stores:

``` php
return [
    'indexes' => [
        'awesome',
    ]
];
```

Any additional indexes you have will be updated [when appropriate](#when-does-indexing-happen).

## Cache Driver

Since the Stache places its data in [Laravel's cache](https://laravel.com/docs/cache#configuration), there's no special configuration necessary to change it.

Whatever your default caching driver is for the rest of your app is where your Stache will be.

By default it's in the filesystem, but of course you can feel free to use Redis, Memcached, etc.

``` env
CACHE_DRIVER=redis
```

## Locks

Statamic will create indexes and build the cache on demand where appropriate. Depending on the amount of content you have, this
could be a resource-heavy operation. To prevent excess CPU and memory usage, subsequent requests will be locked while the cache is being updated.

When a page is requested while the cache is being updated, it will wait until it's ready. If it's not ready after the configured timeout
length (default of 30 seconds), a 503 response will be served with a `<meta>` tag that'll immediately re-request the page.

``` php
return [
    'lock' => [
        'enabled' => true,
        'timeout' => 30,
    ]
]
```
