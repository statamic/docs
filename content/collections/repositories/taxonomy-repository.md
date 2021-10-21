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
| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Taxonomies |
| `find($id)` | Get Taxonomy by `id` |
| `findByHandle($handle)` | Get Taxonomy by `handle` |
| `findByUri($mount)` | Get Taxonomy by `uri` |
| `handleExists($handle)` | Check to see if `Taxonomy` exists |
| `handles()` | Get all `Taxonomy` handles |
| `queryTerms()` | Query Builder for [Terms](/content-queries/term-repository) |

:::tip
The `id` is the same as `handle` while using the default Stache driver.
:::

To work with the with `Taxonomy` Repository, use the following Facade:

```php
use Statamic\Facades\Taxonomy;
```

While the `Taxonomy` Repository does not have a Query Builder, you can still query for Terms _inside_ Taxonomies with the `queryTerms` method. This approach can be useful for retrieving Terms with an existing Taxonomy object.

```php
$tags = Taxonomy::find('tags');

$tags->queryTerms()->get();
```
