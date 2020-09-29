---
title: 'Storing Entries in a Database'
intro: 'Statamic stores entries as markdown files by default, but you don''t have to! This article shows how you can store them in a database.'
id: 853b6690-c1fc-46bc-b865-e61a33d14563
---
Statamic uses a repository pattern to retrieve data from various places. You can read about the feature in general over on the [repositories page](/extending/repositories).

## Database?

This article will be putting the entries into a database, but you could create something that stores them anywhere you want like MongoDB or an API.


## What we're building

In this article we'll create a package that'll contain an Eloquent powered repository, along with all the other moving parts. 

You can check out the finished product on [GitHub][repo], and use it in your own projects.

Since entries are usually the things you'll have the most of, we'll be putting them in the database and leave everything else as flat files.

> If you just want to store your entries in a database and don't want to learn **how** to build it, you can just install the [package][repo].

## Database Schema

One of the great features of Statamic is being able to throw data of any type into an entry and not worry about needing to create corresponding columns in a database.

Here's what our database schema will look like. We'll have a number of columns to hold common, essential things like id, site, etc. Then a `data` column that'll
hold a big blob of JSON for all the fields defined in the blueprint, like what you'd find in your entries' markdown files.

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

> If you wanted to have separate columns for each blueprint field, you could. But your repository would need to be set up to handle that.
> You'd also need to write migrations to add columns whenever you add a field to your blueprints. The JSON column will work for our purposes
> and allow most people to just drop this driver into their site and get going.

The `id` and `origin_id` columns are strings, to make migrating from files easier. If they were incrementing integers, you'd need to update anywhere 
the IDs are referenced. Relationship field values, collections' mount values, structures, etc. This is fairly uncommon, so the [Eloquent model](#the-model)
would need a little tweak to handle it.

## The Repository

The repository is what's used whenever you use the `Entry` Facade. Use `Entry::all()`, it'll call `$repository->all()`, and so on.

If you intend to write your own repository, you'll need to implement all the methods on the `EntryRepository` interface. There's `all`,
`find`, `whereCollection`, `query`, and a bunch more.

The default Stache implementation pushes most of the logic into its query builder. For example, the `find` method looks like this:

``` php
public function find($id): ?Entry
{
    return $this->query()->where('id', $id)->first();
}
```

That's handy for us, because that'll mean we can just extend the Stache repository, point to our own query builder, and customize
only a few additional things. The resulting class looks something like this. It's fairly bare-bones!

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

To have Statamic actually use our class, we'll bind it using the `Statamic::repository()` method in our service provider:

``` php
public function register()
{
    Statamic::repository(EntryRepositoryContract::class, EntryRepository::class);
}
```


## The Query Builder

The Stache entry repository delegates a lot of logic to a query builder which naturally uses the Stache to get the data. Instead, ours will use Eloquent
to read from a database.

Luckily, Statamic already has a base Eloquent Query Builder class (because of the out-of-the-box Eloquent-based user support). Here's a simplified snippet from there:

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

The gist of what this class does is take an actual Eloquent query builder, and proxy most method calls onto that (like `where` or `limit`). Then it would `transform`
regular Eloquent models into whatever Statamic classes are required.

Our Entry query builder can extend this, letting our class also be fairly simple:

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

The `column` method is used whenever we're performing some sort of column based query (like a `where`). If the column isn't in our
list, we'll assume it's in the JSON `data` column, so we'll adjust the query. In case you didn't know, you can totally query
for stuff inside JSON columns.

``` php
$query->where('column->field', 'value')
``` 

Since the query builder is expecting an instance of the Eloquent query builder, we'll need to wire that up in our provider:

``` php
public function register()
{
    $this->app->bind(EntryQueryBuilder::class, function () {
        return new EntryQueryBuilder(EntryModel::query());
    });
}
```

## The Model

Naturally, since we're using Eloquent, we'll need a model. 

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

Pretty simple stuff here. One relationship, which is just to other entries for multi-site. 

The `incrementing` and `keyType` properties are necessary because we're using strings for the `id` column. When you disable `incrementing`, you just have to make
sure that you pass an ID in when saving a new model since Eloquent doesn't know how to generate a new primary key automatically.

## The Entry

In our repository, we re-bound the native Statamic Entry class to our own. We'll extend the native one, but make a handful of tweaks to keep it Eloquent-y.

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

The `fromModel` is used frequently by the query builder to convert an Eloquent model into a Statamic entry. It basically just feeds attributes into the appropriate entry methods.
There's also a getter/setter for setting the `model` so we can reach into it where necessary.

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

The `toModel` method converts the entry back to an Eloquent model, ready to be inserted into the database when saving an entry. We use the `findOrNew` method to it'll grab an existing one if it exists, or just create a freshie.

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

In files, the last modified date comes from a property named `updated_at` in the entry, and falls back to the file's last modified timestamp.
Since we're not dealing with files anymore, we'll just use the model's `updated_at` timestamp.

``` php
    public function lastModified()
    {
        return $this->model->updated_at;
    }
```

If you aren't familiar with Statamic's multi-site feature, here's the extremely condensed version: Entries can be localized based of another entry. The origin id
gets saved inside the localized entry.

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

When you call `$entry->save()`, or `delete()`, it will perform some essential functions inside the method itself that should always just happen, like emitting events. The actual saving/deleting behavior is handed off to the repository.

For instance, when using the Stache, we'll want to write or delete a file. But for our case, we'll need to insert or delete a database record.

So, back in our repository: When it's time to save an entry, we'll make a model (which is either an existing one, or a fresh one), save it to the database, and plop the fresh model back into the entry.

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

While we're keeping the collections stored in the filesystem, there is one thing we need to tweak, so we'll make a custom collection repository too.

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
        foreach ($collection->sites() as $site) {
            $collection
                ->queryEntries()
                ->where('site', $site)
                ->get()->each(function ($entry) {
                    EntryModel::where('id', $entry->id())
                              ->update(['uri' => $entry->uri()]);
                });
        }
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

Everyone loves taxonomies. We can't forget about them. Unless your project doesn't need them, then you could totally skip it.

### Storing associations

Another method in the entry repository is `taxonomize`, which gets called when you save an entry. This is essentially a hook to
let you organize your taxonomy term associations however appropriate. By default, the Stache repository will loop through
the taxonomy fields in the entry and track them in the "taxonomy terms" Stache store.

If you wanted to store all the term associations in the database, you absolutely could. But for the purposes of this example
we'll just let them stay in the Stache. We don't need to do anything.

### Querying Taxonomies

The entry query builder has a couple of extra methods necessary for performing taxonomy based queries. `whereTaxonomy` to filter by
a single term, and `whereTaxonomyIn` to filter by multiple.

Since we're leaving the associations in the Stache, we'll be able to query against the taxonomies the same way as the Stache query builder
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

> If you were to store the associations in the database, you'd need to define your own `whereTaxonomy` and `whereTaxonomyIn` methods that would
> query through a pivot table. Then you would probably not need to override `get`, `paginate`, and `count`.


[repo]: https://github.com/statamic/eloquent-entries
