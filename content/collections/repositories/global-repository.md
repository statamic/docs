---
id: 8159394f-8735-4659-844b-75a58d187007
blueprint: repositories
title: 'Global Repository'
nav_title: Globals
related_entries:
  - 1e91dd54-c452-4e3b-8972-dba83c048d3d
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
---
To work with the GlobalSet Repository, use the following Facade:

```php
use Statamic\Facades\GlobalSet;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all GlobalSets |
| `find($id)` | Get GlobalSets by `id` |
| `findByHandle($handle)` | Get GlobalSets by `handle` |
| `make()` | Makes a new `GlobalSet` instance |

## Querying

Globals are a bit unique in that there is a single "container" – the Global Set – which contains common things like its title and handle. The actual variables are stored separately by site (even when not using the multi-site feature).

``` php
$set = GlobalSet::findByHandle('theme'); // returns a `GlobalSet`
$variables = $set->in($site); // returns a `Variables`
$variables->get('favicon'); // returns the value
```

Of course, you can chain this:

```php
GlobalSet::findByHandle('theme')->in($site)->get('favicon')
```

:::tip
**You must specify your site** when working with GlobalSets, even if you only have **one**. You can use any of these methods:

```php
$set->in('siteHandle'); // A specific site handle from sites.php
$set->inDefaultSite(); // The first site in sites.php
$set->inCurrentSite(); // The site the user is currently visiting.
```
:::


## Creating

Start by making a global set instance with the `make` method. You can pass in the handle.

```php
$globals = GlobalSet::make('settings')->title('Settings');
```

The variables are stored per-site in a `Variables` object. You can make one using the `makeLocalization` method, passing in the site handle. Then attach it to the set.

```php
$variables = $globals->makeLocalization('default');
$variables->data($data); // array of values
$globals->addLocalization($variables);
```

Finally, save it.

```php
$globals->save();
```
