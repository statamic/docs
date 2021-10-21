---
id: 853b6690-c1fc-46bc-b865-e61a33d14563
title: 'Storing Entries in a Database'
intro: 'Statamic stores your content in "flat files" by default, but its data layer is completely driver-driven – giving you the ability to store content **anywhere**. In this article we''ll show you how to store entries in a database with [Laravel Eloquent](https://laravel.com/docs/8.x/eloquent).'
template: page
categories:
  - development
  - database
  - laravel
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821277
---
## Overview

Statamic uses a [repository pattern](/extending/repositories) to interact with your site or application's data. Statamic's core flat file implementation uses the [Stache](/stache) driver, but you can extend and build your own drivers to work with data stored just about anywhere, from MongoDB and [Firebase](https://firebase.google.com/) to a shoebox with a good REST API.

### Why would you want to do this?

The flat file pattern is amazing for a whole pile of reasons. However, if you're going to be working with a huge amount of data (tens of thousands, millions, gazillions, etc), it has its limitations. This is where databases come in.

The ability to trading flexibility for scalability without changing platforms is a powerful feature.


## What we're building

In this article we'll be creating a package that contains an Eloquent powered repository driver along with all the other required moving parts.

You can check out the finished product on [GitHub][repo], and even use it as a template to jumpstart your own project.

For the sake of brevity, we're going to focus only on **entries** for this article. In most cases, entries are the content type with the most records, making them the most likely candidate for needing a database.

Everything you learn here can be applied to Taxonomies, GlobalSets, and all other content types.

:::tip
If you want to store your entries in a database and don't want to learn **how** to do it, you can just jump over to the [package](https://github.com/statamic/eloquent-driver) itself.
:::

## Database Schema

One of Statamic's great features is being able to throw data of any type into an entry and without needing to create corresponding columns in a database.  But here we are in database land, and we need a table and some columns.

Here's what our database schema will look like. We'll have a number of columns to hold common fields like `id`, `site`, and so on. Additionally, we'll create a `data` column that will store JSON for all of the blueprint-defined fields.

``` php
public function up()
{
    Schema::create('entries', function (Blueprint $table) {
        $table->string('id');
        $table->string('site');
        $table->string('origin_id')->nullable();
        $table->boolean('published')->default(true);
        $table->string('status');
        $table->string('slug');
        $table->string('uri')->nullable();
        $table->string('date')->nullable();
        $table->string('collection');
        $table->json('data');
        $table->timestamps();
    });
}
```

If you want separate columns for each blueprint field, go for it. But you'll need to define all those fields in your repository and write migrations to add columns whenever you add a field to your blueprints.

The "catch all" JSON field works well in most cases, and allows you to drop this driver into your site and be off and running with very little fiddling.

**Note:** The `id` and `origin_id` columns are strings to make migrating from files easier. If you want to use incrementing integers and aren't starting on a fresh, empty project, you'll need to update all the IDs in your content to use integers (out of the scope of this article). They might be found in relationship field values, collections' mount values, structures, and so on.

Using strings as IDs is fairly uncommon in Laravel Land, so we'll need to tweak the [Eloquent model](#the-model) to handle it.

## The Repository

When working with Entries in PHP, you use the [`Entry`](https://github.com/statamic/cms/blob/master/src/Contracts/Entries/EntryRepository.php) facade class. It automatically routes the request to proper class depending on what driver you're using. For example, fetching all entries with `Entry::all()`, will call `$repository->all()` behind the scenes, which will offload the work to the Stache driver by default, or in this case – our custom Eloquent driver.

When building your own custom repository class (like we're doing right now), you'll need to implement all of the methods on the `EntryRepository` interface. These methods — like `all`, `find`, `whereCollection`, and `query`, handle all of the data I/O. Think of this class like a little data router.

The default Stache implementation pushes most of the logic into its query builder class. For example, the `find` method looks like this:

``` php
public function find($id): ?Entry
{
    return $this->query()->where('id', $id)->first();
}
```

We  we can extend the Stache repository to gain all of these features, point to our own query builder, and customize only a small set of methods that need tweaking to work with Eloquent. The resulting class looks something like this. As you can see, it's quite minimal.

``` php
<?php

namespace Statamic\Eloquent\Entries;

use Statamic\Contracts\Entries\Entry as EntryContract;
use Statamic\Contracts\Entries\QueryBuilder;
use Statamic\Stache\Repositories\EntryRepository as StacheRepository;

class EntryRepository extends StacheRepository
{
    public static function bindings(): array
    {
        return [
            EntryContract::class => Entry::class,
            QueryBuilder::class => EntryQueryBuilder::class,
        ];
    }

    public function save($entry)
    {
        //
    }

    public function delete($entry)
    {
        //
    }
}
```

Aside from overriding the query builder and entry class bindings, there's also the `save` and `delete` methods that control what happens when you call those methods on an entry. We'll fill those in later.

To have Statamic actually use our class, we'll bind it using the `Statamic::repository()` method in our package's service provider:

``` php
// src/ServiceProvider.php

public function register()
{
    Statamic::repository(EntryRepositoryContract::class, EntryRepository::class);
}
```


## The Query Builder

The Stache entry repository delegates a lot of logic to a query builder which uses the Stache to get the data. Ours will use Eloquent to read from a database instead.

Statamic has a base Eloquent Query Builder class ready for you. Here's a simplified snippet:

``` php
abstract class EloquentQueryBuilder implements Builder
{
    protected $builder;

    public function __construct(EloquentBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function __call($method, $args)
    {
        $this->builder->$method(...$args);

        return $this;
    }

    public function get($columns = ['*'])
    {
        $items = $this->builder->get($columns);

        return $this->transform($items, $columns);
    }

    public function first()
    {
        return $this->get()->first();
    }

    public function where($column, $operator = null, $value = null)
    {
        $this->builder->where($this->column($column), $operator, $value);

        return $this;
    }
}
```

This class takes an actual Eloquent query builder and proxies most method calls onto it (like `where` or `limit`), and then transforms
regular Eloquent models into whatever Statamic classes are required.

Our Entry query builder can extend this, helping us keep our class simple:

``` php
<?php

namespace Statamic\Eloquent\Entries;

use Statamic\Contracts\Entries\QueryBuilder;
use Statamic\Entries\EntryCollection;
use Statamic\Query\EloquentQueryBuilder;
use Statamic\Stache\Query\QueriesTaxonomizedEntries;

class EntryQueryBuilder extends EloquentQueryBuilder implements QueryBuilder
{
    protected $columns = [
        'id', 'site', 'origin_id', 'published', 'status', 'slug', 'uri',
        'date', 'collection', 'created_at', 'updated_at',
    ];

    protected function transform($items, $columns = [])
    {
        return EntryCollection::make($items)->map(function ($model) {
            return Entry::fromModel($model);
        });
    }

    protected function column($column)
    {
        if (! in_array($column, $this->columns)) {
            $column = 'data->'.$column;
        }

        return $column;
    }
}
```

The `transform` method will convert the `Collection` of all the Eloquent models into a `EntryCollection` full of Statamic `Entry` classes.

The `column` method is used whenever we're performing any kind of column based query (like a `where`). If the column isn't in our list, we'll assume it's in the JSON `data` column and adjust the query accordingly.

:::tip
In case you didn't know, you can [run queries](https://dev.mysql.com/doc/refman/8.0/en/json-search-functions.html) on data inside JSON columns. It's pretty awesome.
:::

``` php
$query->where('column->field', 'value')
```

Since the query builder is expecting an instance of the Eloquent query builder, let's wire that up in our provider:

``` php
// src/ServiceProvider.php

public function register()
{
    $this->app->bind(EntryQueryBuilder::class, function () {
        return new EntryQueryBuilder(EntryModel::query());
    });
}
```

## The Model

Since we're using Eloquent, we need a [model](https://laravel.com/docs/8.x/eloquent#defining-models). Let's set one up.

``` php
<?php

namespace Statamic\Eloquent\Entries;

use Illuminate\Database\Eloquent\Model as Eloquent;

class EntryModel extends Eloquent
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    protected $table = 'entries';

    protected $casts = [
        'date' => 'datetime',
        'data' => 'json',
        'published' => 'bool',
    ];

    public function origin()
    {
        return $this->belongsTo(self::class);
    }
}
```

This is pretty basic stuff here – just one relationship (`origin()`) which allows us to handle multi-site entries.

The `incrementing` and `keyType` properties are necessary because we're using strings for the `id` column. When you disable `incrementing` you also need to pass an ID in when saving a new model. Eloquent doesn't know how to generate a new primary key automatically.

## The Entry

In our repository, we re-bound the native Statamic Entry class to our own. We'll extend the native one but make a handful of tweaks to keep it Eloquent-y. Is that a word? It is now.

``` php
<?php

namespace Statamic\Eloquent\Entries;

use Statamic\Eloquent\Entries\EntryModel as Model;
use Statamic\Entries\Entry as FileEntry;
use Statamic\Facades;

class Entry extends FileEntry
{
    protected $model;
```

The `fromModel` is used frequently by the query builder to convert an Eloquent model into a Statamic entry. It's role is to feed attributes into the appropriate entry methods. There's also a getter/setter for setting the `model` so we can reach into it where necessary.

``` php
    public static function fromModel(Model $model)
    {
        return (new static)
            ->locale($model->site)
            ->slug($model->slug)
            ->date($model->date)
            ->collection($model->collection)
            ->data($model->data)
            ->published($model->published)
            ->model($model);
    }

    public function model($model = null)
    {
        if (func_num_args() === 0) {
            return $this->model;
        }

        $this->model = $model;

        $this->id($model->id);

        return $this;
    }
```

The `toModel` method converts the entry _back_ to an Eloquent model where it's ready to be inserted into the database when an entry is saved. We use the `findOrNew` method – it will grab an existing entry if it exists, otherwise create a new one. A freshie, as we say.

```php
    public function toModel()
    {
        return Model::findOrNew($this->id())->fill([
            'id' => $this->id() ?? (string) Str::uuid(),
            'origin_id' => $this->originId(),
            'site' => $this->locale(),
            'slug' => $this->slug(),
            'uri' => $this->uri(),
            'date' => $this->hasDate() ? $this->date() : null,
            'collection' => $this->collectionHandle(),
            'data' => $this->data(),
            'published' => $this->published(),
            'status' => $this->status(),
        ]);
    }
```

When working with files, the last modified date comes from a property named `updated_at` in the entry, which falls back to the file's last modified timestamp. Because we're not dealing with files anymore, we'll use the model's `updated_at` timestamp instead.

``` php
    public function lastModified()
    {
        return $this->model->updated_at;
    }
```

If you aren't familiar with Statamic's multi-site feature, you should know that entries can be localized based off another entry. The `origin_id` gets saved inside the localized entry and is a reference to where the data originated (e.g. the original translation of some content).

Since we're saving the `origin_id` in a column separate from the rest of the YAML-based data, we'll override a few methods to handle reading through the Eloquent relationship.

```php
    public function origin($origin = null)
    {
        if (func_num_args() > 0) {
            $this->origin = $origin;

            return $this;
        }

        if ($this->origin) {
            return $this->origin;
        }

        if (! $this->model->origin) {
            return null;
        }

        return self::fromModel($this->model->origin);
    }

    public function originId()
    {
        return optional($this->origin)->id() ?? optional($this->model)->origin_id;
    }

    public function hasOrigin()
    {
        return $this->originId() !== null;
    }
}
```

## Saving and Deleting

When you call `$entry->save()`, or `delete()`, it will perform essential functions inside the method itself – like emitting events. The actual saving/deleting behavior is handed off to the repository.

For instance, when using the Stache, we may want to write or delete a _file_, but in here we need to insert or delete a database record.

Okay, let's get back to our repository. When it's time to save an entry we'll make a model (an existing or a fresh one), save it to the database, and plop the fresh model back into the entry.

``` php
class EntryRepository extends StacheRepository
{
    //

    public function save($entry)
    {
        $model = $entry->toModel();

        $model->save();

        $entry->model($model->fresh());
    }
```

Deleting is as simple as removing the model:

``` php
    public function delete($entry)
    {
        $entry->model()->delete();
    }
}
```

## Collections

While we're keeping the collections themselves (not the entries) stored in the filesystem, we need to tell it how to route urls to the database. Time to make custom collection repository to define that.

When a collection is updated, specifically it's `route`, all of it's entries will need to have their `uri`s updated.

``` php
<?php

namespace Statamic\Eloquent\Entries;

use Illuminate\Support\Facades\Cache;
use Statamic\Stache\Repositories\CollectionRepository as StacheRepository;

class CollectionRepository extends StacheRepository
{
    public function updateEntryUris($collection)
    {
        $collection
            ->queryEntries()
            ->get()->each(function ($entry) {
                EntryModel::where('id', $entry->id())->update(['uri' => $entry->uri()]);
            });
    }
}
```

``` php
public function register()
{
    Statamic::repository(CollectionRepositoryContract::class, CollectionRepository::class);
}
```

## Taxonomies

We don't want to forget about taxonomies. Unless your project doesn't need them, then you could totally skip them like a bad dessert. Vanilla wafers are a terrible dessert. You should always skip vanilla wafers and save your calories for non-garbage foods.

### Storing associations

Another method in the entry repository is `taxonomize` which is called when an entry is saved. This is a hook to let you organize your taxonomy term associations however appropriate. By default, the Stache repository will loop through the taxonomy fields in the entry and track them in the "taxonomy terms" Stache store.

If you wanted to store all the term associations in the database, you can, but for the purposes of this example we'll just let them stay in the Stache. Let's move on.

### Querying Taxonomies

The entry query builder has a few of required methods for performing taxonomy based queries. `whereTaxonomy` filters entries by
a single term, and `whereTaxonomyIn` filters by multiple.

Since we're leaving the associations in the Stache we'll be able to query against the taxonomies the same way as the Stache query builder
would. Statamic provides a `QueriesTaxonomizedEntries` trait for us to use that'll add those methods. We just need to make sure to compile
them before the query is performed in `get`, `paginate`, and `count`.

``` php
use Statamic\Stache\Query\QueriesTaxonomizedEntries;

class EntryQueryBuilder extends EloquentQueryBuilder implements QueryBuilder
{
    use QueriesTaxonomizedEntries;

    public function get($columns = ['*'])
    {
        $this->addTaxonomyWheres();

        return parent::get($columns);
    }

    public function paginate($perPage = null, $columns = ['*'])
    {
        $this->addTaxonomyWheres();

        return parent::paginate($perPage, $columns);
    }

    public function count()
    {
        $this->addTaxonomyWheres();

        return parent::count();
    }
}
```

:::tip
If you were to store the associations in the database, you'd need to define your own `whereTaxonomy` and `whereTaxonomyIn` methods that would query through a pivot table. In that case you probably wouldn't need to override `get`, `paginate`, and `count`.
:::

## Conclusion

And there you have it. You've built a custom Eloquent repository, re-wired all the data I/O touch-points, and should now be able to handle a butt-ton of entries. Good luck!


[repo]: https://github.com/statamic/eloquent-entries
