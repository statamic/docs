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
| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Collections |
| `find($id)` | Get Collection by `id` |
| `findByHandle($handle)` | Get Collection by `handle` |
| `findByMount($mount)` | Get Asset by mounted entry `id` |
| `handleExists($handle)` | Check to see if `Collection` exists |
| `handles()` | Get all `Collection` handles |
| `queryEntries()` | Query Builder for [Entries](#entries) |
| `whereStructured()` | Get all Structured `Collections` |

:::tip
The `id` is the same as `handle` while using the default Stache driver.
:::

To work with the with `Collection` Repository, use the following Facade:

```php
use Statamic\Facades\Collection;
```

While the `Collection` Repository does not have a Query Builder, you can still query for Entries _inside_ Collections with the `queryEntries` method. This approach can be useful for retrieving Entries with an existing Collection object.

```php
$blog = Collection::find('blog');

$blog->queryAssets()->get();
```
