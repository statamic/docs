---
id: 9c6a0b01-449e-49dd-8fa6-11b975d2726d
blueprint: repositories
title: 'Collection Repository'
class: \Statamic\Facades\Collection
nav_title: Collections
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - 44c3da60-ef47-408e-afc4-a33026c86f5d
  - 045a6e54-c792-483a-a109-f07251a79e47
  - 7202c698-942a-4dc0-b006-b982784efb03
---
To work with the with `Collection` Repository, use the following Facade:

```php
use Statamic\Facades\Collection;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Collections |
| `find($id)` | Get Collection by `id` |
| `findByHandle($handle)` | Get Collection by `handle` |
| `findByMount($mount)` | Get Collection by mounted entry `id` |
| `findOrFail($id)` | Get Collection by `id`. Throws a `CollectionNotFoundException` when the collection cannot be found. |
| `handleExists($handle)` | Check to see if `Collection` exists |
| `handles()` | Get all `Collection` handles |
| `queryEntries()` | Query Builder for [Entries](/repositories/entry-repository) |
| `whereStructured()` | Get all Structured `Collections` |
| `make()` | Makes a new `Collection` instance |

:::tip
The `id` is the same as `handle` while using the default Stache driver.
:::

## Querying

While the `Collection` Repository does not have a Query Builder, you can still query for Entries _inside_ Collections with the `queryEntries` method. This approach can be useful for retrieving Entries with an existing Collection object.

```php
$blog = Collection::find('blog');

$blog->queryEntries()->get();
```

When a collection can't be found, the `Collection::find()` method will return `null`. If you'd prefer an exception be thrown, you may use the `findOrFail` method:

```php
Collection::findOrFail('blog');
```

## Creating

Start by making an instance of a collection with the `make` method. You can pass the handle into it.

```php
$collection = Collection::make('assets');
```

You may call additional methods on the collection to customize it further.

```php
$collection
    ->title('Blog')
    ->routes('/blog/{slug}') // a string, or array of strings per site
    ->mount('blog-page') // id of an entry
    ->dated(true)
    ->ampable(false)
    ->sites(['one', 'two']) // array of handles
    ->template('template')
    ->layout('layout')
    ->cascade($data) // an array
    ->searchIndex('blog') // index name
    ->revisionsEnabled(false)
    ->defaultPublishState('published') // or 'draft'
    ->structureContents($structure) // an array
    ->sortField('field') // the field to sort by default
    ->sortDirection('asc') // or 'desc'
    ->taxonomies(['tags']) // array of handles
    ->propagate(true); // whether newly created entries propagate to other sites
```

Finally, save it.

```php
$collection->save();
```
