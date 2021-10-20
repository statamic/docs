---
title: Repositories
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347424
intro: Statamic uses a repository pattern to retrieve data from various places.
stage: 1
id: c3da9537-5d5f-4b84-a4be-882b89217151
---

For example, when you call `Entry::whereCollection('blog')`, it asks "the entry repository" to get the blog entries
instead of immediately assuming the entries will be located in a blog directory on the filesystem.

Out of the box, Statamic will typically use an implementation that gets data from the "Stache", which is our file-backed database.

## Custom Repositories

Let's say you want to store your entries in a database. You would need to swap the default entry repository (which gets entries from the Stache)
with your own that would get entries from a database.

In a service provider's `register` you can re-bind the contract using the `Statamic::repository()` method:

``` php
<?php

namespace App\Providers;

use App\DatabaseEntryRepository;
use Illuminate\Support\ServiceProvider;
use Statamic\Contracts\Entries\EntryRepository;
use Statamic\Statamic;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        Statamic::repository(
            EntryRepository::class,
            DatabaseEntryRepository::class
        );
    }
}
```

If you only need to customize small parts, feel free to have your repository class extend Statamic's default ones. For example:

``` php
use Statamic\Stache\Repositories\EntryRepository;

class MyEntryRepository extends EntryRepository
{
    //
}
```

## Custom Data Classes

Each repository is also responsible for making instances of their items. eg. an `EntryRepository` makes `Entry` classes. The `make` method will resolve the appropriate class out of the container based on the contract.

The repository has a `bindings` method that defines these. Your custom repository may override these to return different classes.

``` php
public static function bindings(): array
{
    return [
        Statamic\Contracts\Entries\Entry::class => DatabaseEntry::class,
        Statamic\Contracts\Entries\QueryBuilder::class => DatabaseEntryQueryBuilder::class,
    ];
}
```

Alternatively, if you want to use a custom item class without customizing the entire repository, you're free to just re-bind that class in your service provider's `boot` method (so it's re-bound after everything else). This could be more useful to you if you just need to customize a method or two.

``` php
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(
            Statamic\Contracts\Entries\Entry::class,
            CustomEntry::class
        );
    }
}
```

:::tip
Make sure to clear your cache after changing a binding like this.
:::
