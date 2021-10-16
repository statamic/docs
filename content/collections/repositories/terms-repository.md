---
id: 322d7330-0967-428c-9d15-5b289e920466
blueprint: repositories
title: 'Taxonomy Terms Repository'
nav_title: Terms
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - ba832b71-a567-491c-b1a3-3b3fae214703
  - 6a18eac8-6139-419c-9d64-a2c960ccc3cd
  - 42d2d87c-5af6-4856-9ee0-9548439df772
---
## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Terms |
| `find($id)` | Get Term by `id` |
| `findByUri($uri)` | Get Term by `uri` |
| `query()` | Query Builder |
| `whereTaxonomy($handle)` | Get Terms in a `Taxonomy` |
| `whereInTaxonomy([$handles])` | Get all Terms in an array of `Taxonomys` |

To work with the Repository Term queries, use the following Facade:

```php
use Statamic\Facades\Term;
```

### Examples {.popout}

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
