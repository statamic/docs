---
title: Repositories
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347424
id: c3da9537-5d5f-4b84-a4be-882b89217151
intro: Statamic uses a repository pattern to retrieve data from various places.
---

For example, when you call `Entry::whereCollection('blog')`, it asks "the entry repository" to get the blog entries
instead of immediately assuming the entries will be located in a blog directory on the filesystem.

Out of the box, Statamic will typically use an implementation that gets data from the "Stache", which is our file-backed database.

## Custom Repositories

Let's say you want to store your entries in a database. You would need to swap the default entry repository (which gets entries from the Stache)
with your own that would get entries from a database.

In a service provider, you can re-bind the contract:

``` php
<?php

namespace App\Providers;

use App\DatabaseEntryRepository;
use Illuminate\Support\ServiceProvider;
use Statamic\Contracts\Entries\EntryRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EntryRepository::class, DatabaseEntryRepository::class);
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

Each repository is also responsible for making instances of their items. eg. an `EntryRepository` should know how to make an `Entry` class.

You can have the repository return your custom classes:

``` php
public function make(): EntryContract
{
    return new \App\DatabaseEntry;
}
```
