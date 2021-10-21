---
id: 8159394f-8735-4659-844b-75a58d187007
blueprint: repositories
title: 'Global Repository'
nav_title: Globals
related_entries:
  - 1e91dd54-c452-4e3b-8972-dba83c048d3d
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
---
## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all GlobalSets |
| `find($id)` | Get GlobalSets by `id` |
| `findByHandle($handle)` | Get GlobalSets by `handle` |

To work with the GlobalSet Repository, use the following Facade:

```php
use Statamic\Facades\GlobalSet;
```

Globals are a bit unique in that they are variables in a single "container" (the Global Set).

``` php
GlobalSet::findByHandle('theme')
  ->inCurrentSite()
  ->get('favicon');
```

:::tip
**You must specify your site** when working with GlobalSets, even if you only have **one**. You can use either of these methods:

```php
GlobalSet::findByHandle($handle)
    ->in($site)
    ->get($var)

// Get the current site
GlobalSet::findByHandle($handle)
    ->inCurrentSite()
    ->get();
:::
