---
id: 322d7330-0967-428c-9d15-5b289e920466
blueprint: repositories
title: 'Taxonomy Term Repository'
nav_title: Terms
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - ba832b71-a567-491c-b1a3-3b3fae214703
  - 6a18eac8-6139-419c-9d64-a2c960ccc3cd
  - 42d2d87c-5af6-4856-9ee0-9548439df772
---

To work with the Repository Term queries, use the following Facade:

```php
use Statamic\Facades\Term;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Terms |
| `find($id)` | Get Term by `id` |
| `findByUri($uri)` | Get Term by `uri` |
| `findOrFail($id)` | Get Term by `id`. Throws a `TermNotFoundException` when the term cannot be found. |
| `query()` | Query Builder |
| `make()` | Makes a new `Term` instance |

## Querying

#### Examples {.popout}

#### Get a single term by its id

When getting a single term by its ID, the value of the `$id` parameter should be `taxonomy_handle::term_id`.

```php
Term::query()->where('id', 'tags::123')->first();

// Or with the shorthand method
Term::find('tags::123');
```

#### Get all tags

```php
Term::query()
    ->where('taxonomy', 'tags')
    ->get();
```

#### Get all tags in a collection

```php
Term::query()
    ->where('collection', 'blog')
    ->where('taxonomy', 'tags')
    ->get();
```

#### Get all tags in multiple collections

```php
Term::query()
    ->where('taxonomy', 'tags')
    ->whereIn('collection', ['blog', 'news'])
    ->get();
```

#### Only include tags attached to entries

```php
Term::query()
    ->where('taxonomy', 'tags')
    ->where('entries_count', '>=', 1);
    ->get();
```


## Creating

Start by making an instance of a term with the `make` method.
You need at least a slug and the taxonomy.

```php
$term = Term::make()->taxonomy('tags')->slug('my-term');
```

Data for a term is stored on a per site basis, even if you only are using a single site.

The method expects a site handle and an array of key-value pairs.
```php
// Example for a single site
$term->dataForLocale('default', [
    'mandalorian_code' => 'This Is The Value',
    //...
]);
```

When using [multi-site](/multi-site), you can pass different data to each site.
```php
$term->dataForLocale('default', $data);
$term->dataForLocale('fr', $frenchData);
```

You may call additional methods on the term to customize it further.

```php
$term->blueprint('tag');
```

Finally, save it. It'll return a boolean for whether it succeeded.

```php
$term->save(); // true or false
```
