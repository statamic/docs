---
id: 42d2d87c-5af6-4856-9ee0-9548439df772
blueprint: repositories
title: 'Taxonomy Repository'
class: \Statamic\Facades\Taxonomies
nav_title: Taxonomies
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - ba832b71-a567-491c-b1a3-3b3fae214703
  - 6a18eac8-6139-419c-9d64-a2c960ccc3cd
---
To work with the with `Taxonomy` Repository, use the following Facade:

```php
use Statamic\Facades\Taxonomy;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Taxonomies |
| `find($id)` | Get Taxonomy by `id` |
| `findByHandle($handle)` | Get Taxonomy by `handle` |
| `findByUri($mount)` | Get Taxonomy by `uri` |
| `handleExists($handle)` | Check to see if `Taxonomy` exists |
| `handles()` | Get all `Taxonomy` handles |
| `queryTerms()` | Query Builder for [Terms](/content-queries/term-repository) |
| `make()` | Makes a new `Taxonomy` instance |

:::tip
The `id` is the same as `handle` while using the default Stache driver.
:::

## Querying

While the `Taxonomy` Repository does not have a Query Builder, you can still query for Terms _inside_ Taxonomies with the `queryTerms` method. This approach can be useful for retrieving Terms with an existing Taxonomy object.

```php
$tags = Taxonomy::find('tags');

$tags->queryTerms()->get();
```

## Creating

Start by making an instance of a taxonomy with the `make` method. You can pass the handle into it.

```php
$taxonomy = Taxonomy::make('tags');
```

You may call additional methods on the taxonomy to customize it further.

```php
$taxonomy
    ->title('Tags')
    ->cascade($data) // an array
    ->revisionsEnabled(false)
    ->searchIndex('tags')
    ->defaultPublishState('published') // or 'draft'
    ->sites(['one', 'two']) // array of handles
```

Finally, save it.

```php
$taxonomy->save();
```
