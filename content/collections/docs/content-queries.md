---
id: e7833062-e05c-42c9-ad35-dc5077f1f0b8
blueprint: page
title: 'Content Queries'
intro: 'Statamic provides a fluent query builder interacting with your content and data in PHP-land. If you think of them as Laravel Eloquent Models, you should feel right at home.'
---
## Overview

Each of the core Statamic data types has its own Facade used to access an underlying repository class so you can query, create, modify, and delete content. Working with data in this manner is usually done in a [Controller](/controllers), with any retrieved data being passed into a view.

These methods will work no matter which driver you're using — flat files, Eloquent/MySQL, or any other custom repo driver.

[Learn how Statamic can use different storage methods!](/extending/repositories)

:::tip
While Statamic's Query builder is very similar to [Laravel's Query Builder](https://laravel.com/docs/12.x/queries), they are **completely separate implementations**.

What follows is complete documentation on all available methods. If you need a method available in Laravel that we don't currently support, feel free to open a [feature request](https://github.com/statamic/ideas) or better yet, a [Pull Request](https://github.com/statamic/cms)!
:::

## Retrieving data

There are two different types of classes you'll interact with while querying content: Repositories and Query Builders.

### Repositories

Each Facade interacts with a **repository**, which allows you to get data about the desired data type. For example, you can use the `Entry` Facade to get an entry, or the `GlobalSet` Facade to get all the variables inside of it.

```php
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;

Entry::find('abc123');
GlobalSet::findByHandle('footer')->inDefaultSite()->get('copyright');
```

### Query builders

Some Facades also have a **Query Builders** that allows you to query, filter, and narrow down the results you desire. The `Entry` Facade's Query Builder allows you to find all the entries in a collection, by a specific author, and so on.

:::tip
All Query Builders are part of a Repository, but not all Repositories have a Query Builder. Just like how all donuts are desserts, but not all desserts are donuts. 🍩
:::

**Query Builders** allow you to assemble a query, chain additional constraints onto it, and then invoke the `get` method to get the results:

```php
use Statamic\Facades\Entry;

$entries = Entry::query()
  ->where('collection', 'blog')
  ->limit(5)
  ->get();
```

This would return a `Collection` of the items. In this particular example, you would have a `Collection` of `Entry` objects.

### Examples {.popout}

#### Getting a single record

If you only want to get a single record, you may use the `first` method. This method will return a single data object:

```php
Entry::query()
    ->where('collection', 'blog')
    ->first();
```

#### Getting specific fields

This method is really only helpful when using a database — it improves query speed by performing column `SELECT`s behind the scenes.

```php
Entry::query()
    ->where('collection', 'blog')
    ->get(['title', 'hero_image', 'content']);
```

## Basic where clauses

### Where
You may use the query builder's `where` method to add "where" clauses to the query. The most basic call to the `where` method requires three arguments. The first argument is the name of the field. The second argument is an operator, which can be any of the supported operators. The third argument is the value to compare against the field's value.

For example, the following query gets entries where the value of a `status` field is `featured`.

```php
Entry::query()
    ->where('status', '=', 'featured') // [tl! ~~]
    ->get();
```

As a shorthand for an "equals" query, you may pass the value as the second argument to the `where` method. Statamic will assume you would like to use the `=` operator:

```php
Entry::query()->where('status', 'featured')->get();
```

You can chain where clauses, filtering records based on more than one condition with AND:

```php
Entry::query()
    ->where('status', '=', 'featured')
    ->where('status', '!=', 'sticky')
    ->get();
```

This same query can also be written using one where clause:

```php
Entry::query()
    ->where([
      ['status', '=', 'featured'],
      ['status', '!=', 'sticky']
    ])
    ->get();
```

You can query entries across multiple conditions using `orWhere()`:

```php
Entry::query()
    ->where('status', '=', 'featured')
    ->orWhere('status', '=', 'sticky') // [tl! ~~]
    ->get();
```

### WhereBetween
The `whereBetween` method lets you verify that a field's value lies between two values that you pass:

```php
Entry::query()
    ->whereBetween('numeric_field', [0, 1000]) // [tl! ~~]
    ->get();
```

You can also use the `whereNotBetween` method to verify that a field's value does not lie between two values that you pass:

```php
Entry::query()
    ->whereNotBetween('numeric_field', [0, 1000]) // [tl! ~~]
    ->get();
```

Note: `orWhereBetween` and `orWhereNotBetween` are also supported.


### WhereColumn
The `whereColumn` method lets you compare a field's value to that of another field:

```php
Entry::query()
    ->whereColumn('published', '=', 'status') // [tl! ~~]
    ->get();
```

Note: `orWhereColumn` is also supported.


### WhereDate

The `whereDate` method may be used to compare a column's value against a date:

```php
$users = Entry::query()->whereDate('created_at', '2016-12-31')->get();
```

The `whereMonth` method may be used to compare a column's value against a specific month:

```php
$users = Entry::query()->whereMonth('created_at', '12')->get();
```

The `whereDay` method may be used to compare a column's value against a specific day of the month:

```php
$users = Entry::query()->whereDay('created_at', '31')->get();
```

The `whereYear` method may be used to compare a column's value against a specific year:

```php
$users = Entry::query()->whereYear('created_at', '2016')->get();
```

The `whereTime` method may be used to compare a column's value against a specific time:

```php
$users = Entry::query()->whereTime('created_at', '=', '11:20:45')->get();
```


### WhereIn
The `whereIn` method lets you check a field against an a given array of values:

```php
Entry::query()
    ->whereIn('status', ['featured', 'sticky', 'special']) // [tl! ~~]
    ->get();
```

You can also use the `whereNotIn` method to ensure a given field's value is not contained in a given array of values:

```php
Entry::query()
    ->whereNotIn('status', ['draft', 'boring']) // [tl! ~~]
    ->get();
```

Note: `orWhereIn` and `orWhereNotIn` are also both supported.


### WhereNull
The `whereNull` method lets you check whether a field's value is null:

```php
Entry::query()
    ->whereNull('published') // [tl! ~~]
    ->get();
```

You can also use the `whereNotNull` method to check if a field's value is not null:

```php
Entry::query()
    ->whereNotNull('published') // [tl! ~~]
    ->get();
```

Note: `orWhereNull` and `orWhereNotNull` are also both supported.



## Complex where clauses
Complex queries can be made by using closure-based wheres containing any of the [basic where clauses](#basic-where-clauses):

```php
Entry::query()
    ->where(function ($query) {
		$query->where('status', 'featured')
      		->orWhere('status', 'sticky');
    })
    ->orWhere(function ($query) {
		$query->where('title', '!=', 'statamic')
      		->where('status', 'boring');
    })  
    ->get();
```


## Conditional clauses
Conditional clauses can be applied based on another condition, for example the value for an input on the HTTP request. 

```php
Entry::query()
    ->when($request->input('rad'), function ($query) {
		$query->where('status', 'featured')
      		->orWhere('status', 'sticky');
    })
    ->get();
```

You can also pass a default value which will be applied when the condition fails:

```php
Entry::query()
    ->when($request->input('rad'), function ($query) {
		$query->where('status', 'featured')
      		->orWhere('status', 'sticky');
    }, function ($query) {
		$query->where('status', '!=', 'featured')
      		->where('status', '!=', 'sticky');
    })
    ->get();
```

If you want to simply apply a clause when a value fails you can use `unless()`:

```php
Entry::query()
    ->unless($request->input('rad'), function ($query) {
		$query->where('status', 'featured')
      		->orWhere('status', 'sticky');
    })
    ->get();
```

## JSON where clauses
JSON values can be queries using the '->' selector:

```php
Entry::query()
    ->where('my_field->sub_field', '!=', 'statamic') // [tl! ~~]
    ->get();
```

You can query JSON arrays using `whereJsonContains()`

```php
Entry::query()
    ->whereJsonContains('my_array_field->sub_field', 'statamic') // [tl! ~~]
    ->get();
```

Or can pass an array of values. This will match if any of the values are found in the field.

```php
Entry::query()
    ->whereJsonContains('my_array_field->sub_field', ['statamic', 'is', 'rad']) // [tl! ~~]
    ->get();
```

If you want to check for **any** value being present, use `whereJsonOverlaps`.

```php
Entry::query()
    ->whereJsonOverlaps('my_array_field->sub_field', ['statamic', 'is', 'rad']) // [tl! ~~]
    ->get();
```

You can use `whereJsonDoesntContain()` and `whereJsonDoesntOverlap()` to query the absence of a value or values in a JSON array:

```php
Entry::query()
    ->whereJsonDoesntContain('my_array_field->sub_field', 'statamic') // [tl! ~~]
    ->get();
    
Entry::query()
    ->whereJsonDoesntOverlap('my_array_field->sub_field', 'statamic') // [tl! ~~]
    ->get();
```

You can use whereJsonLength method to query JSON arrays by their length:

```php
Entry::query()
    ->whereJsonLength('my_array_field->sub_field', 1) // [tl! ~~]
    ->get();
```

```php
Entry::query()
    ->whereJsonLength('my_array_field->sub_field', '>', 1) // [tl! ~~]
    ->get();
```

Note: `orWhereJsonContains` and `orWhereJsonLength` are also both supported.



## Operators

The following operators are available in [basic where clauses](#basic-where-clauses) when appropriate for a targeted field's datatype, just like SQL.

| Operator | Description |
| -------- | ----------- |
| `=` | Equals |
| `<>` or `!=` | Not Equals |
| `like` | Like |
| `not like` | Not Like |
| `regexp` | Like Regex |
| `not regexp` | Not Like Regex |
| `>` | Greater Than |
| `<` | Less Than |
| `>=` | Greater Than Or Equal To |
| `<=` | Less Than Or Equal To |


### Like & Not Like

The `like` operator is used in `where` clause to search for a specified pattern in a field. `not like` is the inverse, ensuring that the results **do not** match a pattern.

There are two wildcards used in conjunction with the `like` operator:

- The percent sign `%` represents zero, one, or multiple characters
- The underscore sign `_` represents one, single character

#### Examples {.popout}

#### Get all Users with a gmail email address
```php
User::query()
    ->where('email', 'like', '%@gmail.com')
    ->get();
```

#### Get all Entries where "wip" is not in the title
```php
Entry::query()
    ->where('title', 'not like', '% wip %')
    ->get();
```

#### Get all Assets with "thumbnail" in the filename.
```php
Asset::query()
    ->where('filename', 'like', '%thumbnail%')
    ->get();
```

#### Get all Users who are (probably) not doctors
```php
User::query()
    ->where('name', 'not like', ['Dr.%', '%MD', '%M.D.'])
    ->get();
```

### Regex & Not Regex

The `regex` operator is used in `where` clause to search for records where a field matches a given regular expression, while `not regex` is the inverse — ensuring that results **do not** match a regular expression.

:::tip
Internally, this rule uses the PHP `preg_match` function. The pattern specified should obey the same formatting required by `preg_match` and therefore also include valid delimiters. For example: `'/^.+$/i'`.
:::

#### Examples {.popout}

#### Find entries with Antlers expressions in content
```php
Entry::query()
    ->where('content', 'regexp', '/{{/')
    ->get();
```

#### Find all Star Trek movie subtitles but not Star Wars
```php
Entry::query()
    ->where('collection', 'movies')
    ->where('title', 'not regexp', '/m | [tn]|b/')
    ->get();
// [tl! collapse:start]
// Okay, so this regex doesn't work on any of the Star Wars
// movies after Rogue One but let's not split hairs here.
// This is a good example and you know it.

// If we can get enough support though we can submit a
// petition to Disney to rename the last 3 Skywalker sequels
// so we don't need to change our regex:

// The Force Awakens -> Awakening of the Force
// The Last Jedi -> Near Extinction of the Jedi
// The Rise of Skywalker -> Ascent of the Walker in the Sky [tl! collapse:end]
```

### Greater Than & Less Than (Or Equal To)

The `greater than` operator is used to compare two values. If the first is greater than the second, the match will be included. The `greater than or equals` operator will include exact matches.

The `less than` operator is used to compare two values. If the first is less than the second, the match will be included. The `less than or equals` operator will include exact matches.

#### Examples {.popout}

#### Find all Users old enough to enjoy a dram of whisky in the U.S.

```php
User::query()
    ->where('age', '>=', 21)
    ->get();
```

#### Find all Pre-Y2K news

```php
Entry::query()
    ->where('collection', 'news')
    ->where('date', '<', '2000')
    ->get();
```

## Ordering, Limiting, & Offsetting

The `orderBy` method allows you to sort by a given field, or in random order:

```php
Entry::query()->orderBy('date', 'asc')->get();
Entry::query()->orderByDesc('title')->get(); // the same as ->orderBy('title', 'desc')
Entry::query()->inRandomOrder()->get();
```

You may limit and/or skip results by using the `limit` and `offset` methods:

```php
Entry::query()->offset(5)->limit(5)->get();
```

## Count

The query builder also provides the `count` method for retrieving the number of records returned.

```php
Entry::query()->count();
```

## Paginating

Paginate results by invoking the `paginate` method on a query instead of `get`, and specifying the desired number of results per page.

```php
Entry::query()->paginate(15);
```

This will return an instance of `Illuminate\Pagination\LengthAwarePaginator` that you can use to assemble the pagination style of your choice.

:::tip
You can [learn more about the LengthAwarePaginator](https://laravel.com/docs/12.x/pagination#paginator-instance-methods)in the Laravel docs.
:::

## Chunking

By chunking down the results of a query you receive a small chunk of results that you can each pass into a closure for further processing or manipulation.

Expects both a `$count` and `$callback` argument.

```php
Entry::query()->chunk(25, function($entries) {
    // do something with each chunk
});
```

:::tip
You can [learn more about chunking query results](https://laravel.com/docs/12.x/queries#chunking-results) in the Laravel docs.
:::

## Lazy streaming

Lazily streaming query results allows you to define a number of results to be returned from the query, similar to [chunking](#chunking). The difference is that instead of being able to pass each chunk into a callback, you receive a `LazyCollection`. This can help in situations where you're working with large datasets while keeping the memory usage low.

The chunk size for the lazy query should be at least `1` and defaults to `1000`.

```php
Entry::query()->lazy(100)
```

:::tip
You can learn more about [lazily streaming query results](https://laravel.com/docs/12.x/queries#streaming-results-lazily) and [LazyCollections](https://laravel.com/docs/12.x/collections#lazy-collections) in the Laravel docs.
:::

## Repository classes

Head to the [Repositories Reference](reference/repositories) area for the complete list of classes and methods.
