---
id: 4238bce4-a94b-4d07-96fa-ea77c1d8e48d
blueprint: repositories
title: 'Entry Repository'
nav_title: Entries
related_entries:
  - e7833062-e05c-42c9-ad35-dc5077f1f0b8
  - acee879a-c832-449d-a714-c57ea5862717
  - 9c6a0b01-449e-49dd-8fa6-11b975d2726d
  - 7202c698-942a-4dc0-b006-b982784efb03
---
To work with the Entry Repository, use the following Facade:

```php
use Statamic\Facades\Entry;
```

## Methods

| Methods | Description |
| ------- | ----------- |
| `all()` | Get all Entries |
| `find($id)` | Get Entry by `id` |
| `findByUri($uri, $site)` | Get Entry by `uri`, optionally in a site |
| `findOrFail($id)` | Get Entry by `id`. Throws an `EntryNotFoundException` when entry can not be found. |
| `query()` | Query Builder |
| `whereCollection($handle)` | Get all Entries in a `Collection` |
| `whereInCollection([$handles])` | Get all Entries in an array of `Collections` |
| `make()` | Makes a new entry instance |

## Querying

#### Examples {.popout}

#### Get a single entry by its id

```php
Entry::query()->where('id', 123)->first();

// Or with the shorthand method
Entry::find(123);
```

When an entry can't be found, the `Entry::find()` method will return `null`. If you'd prefer an exception be thrown, you can use the `findOrFail` method:

```php
Entry::findOrFail(123);
```

#### Get an entry by its URI

```php
Entry::query()->where('uri', 'blog/my-first-post')->first();

// Or with the shorthand method
Entry::findByUri('/blog/my-first-post');
```

:::tip
**What is the difference between `URI` and `URL`?** `URL` includes the site root (e.g. `/fr/` in a multisite), if there is one, while `URI` is site agnostic and will not. As you may have surmised, when you only have a single site — they are identical.
:::

#### Get all entries in a collection

```php
Entry::query()
  ->where('collection', 'blog')
  ->get();
```

#### Get an entry from a collection by its slug

```php
Entry::query()
    ->where('collection', 'blog')
    ->where('slug', 'my-first-post')
    ->first();
```

#### Get an entry by its slug in a multi-site install

```php
Entry::query()
    ->where('collection', 'team')
    ->where('slug', 'director')
    ->where('site', 'albuquerque')
    ->get();
```

#### Get all Pre-Y2K news

```php
Entry::query()
    ->where('collection', 'news')
    ->where('date', '<', '2000') // [tl! ~~]
    ->get();
```

#### Get all of today's news

```php
use Illuminate\Support\Carbon;

Entry::query()
    ->where('collection', 'news')
    ->where('date', Carbon::parse('today'))
    ->get();
```

#### Get the last 12 months of news

```php
use Illuminate\Support\Carbon;

Entry::query()
    ->where('collection', 'news')
    ->where('date', '>=', Carbon::parse('now')->subYears(1))
    ->get();
```

#### Find all entries authored by Jack

```php
$author = User::findByEmail('jack@statamic.com');

Entry::query()
    ->where('collection', 'news')
    ->where('author', $author->id())
    ->get();
```

#### Get all entries using a specific Blueprint

```php
Entry::query()
    ->where('blueprint', 'editorial')
    ->get();
```

#### Get all published and scheduled entries

```php
Entry::query()
  ->whereIn('status', ['published', 'scheduled'])
  ->get();
```

:::tip
**What is the difference between querying against `published` and `status`?** Read more on [date behavior and published status](/collections#date-behavior-and-published-status)!
:::

### Get all entries with taxonomy terms

When you want to query all entries with a specific term, you should use the `whereTaxonomy` method:

```php
Entry::query()
  ->where('collection', 'news')
  ->whereTaxonomy('categories::laravel')
  ->get();
```

In the above example, `categories` is the taxonomy's handle and `laravel` is the term's slug.

When you want to query all entries with **multiple** terms, you should instead use the `whereTaxonomyIn` method:

```php
Entry::query()
  ->where('collection', 'news')
  ->whereTaxonomyIn(['categories::laravel', 'categories::statamic'])
  ->get();
```

:::warning
**This only works when the taxonomy [is linked in your collection's config](/collections#taxonomies).** If it's not linked in the collection config, you should use the `whereJsonContains` method instead:

```php
Entry::query()
  ->where('collection', 'news')
  ->whereJsonContains('categories_field', ['laravel', 'statamic'])
  ->get();
```
:::

## Creating

Start by making an instance of an entry with the `make` method.
You need at least a slug and the collection before you can save an entry.

```php
$entry = Entry::make()->collection('blog')->slug('my-entry');
```

You may call additional methods on the entry to customize it further.

```php
$entry
  ->date($carbon) // or string of Y-m-d or Y-m-d-Hi
  ->published(true) // or false for a draft
  ->locale('default') // the site handle. defaults to the default site.
  ->blueprint('article') // set entry blueprint
  ->data(['foo' => 'bar']) // an array of data (front-matter)
  ->origin($origin); // another entry instance
```

Finally, save it. It'll return a boolean for whether it succeeded.

```php
$entry->save(); // true or false
```
