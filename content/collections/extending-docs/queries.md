---
title: Queries
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347265
intro: Statamic has a number of query builders that provide a convenient, fluent interface for retrieving data. It's very similar to Eloquent in Laravel.
stage: 1
id: 51a52222-9be7-46b1-8388-059019281a56
---
## Retrieving results

You may use the `query` method on a number of repository classes to begin a query. This method returns a fluent query builder instance for the given item, allowing you to chain more constraints onto the query then get the results using the `get` method.

For example, here's how you could get all the entries:

``` php
Statamic\Facades\Entry::query()->get();
```

This would typically return a `Collection` of the items. In this case, it'd be full of `Entry` objects.


## Filtering results

In the example above, you may notice it's exactly the same as running `Entry::all()`. The power of using the query builder is to let you chain more complex restraints onto it. For instance, you could filter down the items.

You may use the `where` method to add simple where clauses:

``` php
Entry::query()
    ->where('collection', 'blog')
    ->where('food', 'bacon')
    ->get();
```

You may use the `whereIn` method to check against an array of values:

``` php
Entry::query()
    ->whereIn('food', ['bacon', 'cheese'])
    ->get();
```

## Ordering, Limit, and Offset

The `orderBy` method allows you to sort by a given field:

``` php
Entry::query()->orderBy('title', 'desc')->get();
```

You may limit and/or skip results by using the `limit` and `offset` methods:

``` php
Entry::query()->offset(5)->limit(5)->get();
```

## Aggregates

The `count` method allows you to get the number of records.

``` php
Entry::query()->count();
```


## Pagination

You may paginate a result set by finishing your query with the `paginate` method.

``` php
Entry::query()->paginate(15);
```

This will return an instance of `Illuminate\Pagination\LengthAwarePaginator`.


## Available Query Builders

### Assets

Query against all assets.

``` php
Statamic\Facades\Asset::query()
    ->where('container', 'main')
    ->where('folder', 'images')
    ->where('alt', 'like', '%potato%')
    ->get();
```

The `container` and `folder` columns will allow you to refine the location of the assets, where any other column will filter from asset data values.

### Asset Container Assets

Query against all assets in a particular container.
Similar to the above query, but with the container already implied.

``` php
Statamic\Facades\AssetContainer::find('main')
    ->queryAssets()
    ->where('folder', 'images')
    ->get();
```

### Entries

Query against all entries.

``` php
Statamic\Facades\Entry::query()
    ->where('title', 'like', '%hello%')
    ->get();
```

### Collection Entries

Query against entries in a particular collection.
Similar to the above query, but with the container already implied.

``` php
Statamic\Facades\Collection::find('blog')
    ->queryEntries()
    ->where('title', 'like', '%news%')
    ->get();
```

### Users

Query against all users.

``` php
Statamic\Facades\User::query()
    ->where('email', 'john@example.com')
    ->first();
```

### User Group Users

Query against users in a particular user group.
Similar to the above query, but with the group already implied.

``` php
Statamic\Facades\UserGroup::find('admin')
    ->queryUsers()
    ->where('mustache', true)
    ->get();
```


## Caveats

The Statamic query builder are **similar to** Laravel's Eloquent and database query builders, but they are _not entirely the same_.

Where the Laravel query builders would translate to SQL under the hood, the Statamic equivalent ones may not. So, for instance, you
cannot use features such a raw SQL expressions, joins, etc.

If you have re-bound a particular repository or query builder to an Eloquent equivalent, you may be able to use these features,
however if you intend to distribute it in an addon, keep in mind that not everyone may be using a database.
