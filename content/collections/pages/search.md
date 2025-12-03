---
id: 420f083d-99be-4d54-9f81-3c09cb1f97b7
blueprint: page
title: Search
intro: "Help your visitors find what they're looking for with search. Use  configurable indexes to configure which fields are important, which aren't, and fine-tune your way to relevant results."
template: page
related_entries:
  - 5fcf5a56-c120-4988-a4c7-0c5e942327b7
  - 2022056a-d901-423a-aaa7-ee04fff40739
  - fe8ec156-447d-4f03-974f-0251a8c53244
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1633035293
---
## Overview

There are four components (coincidentally, the same number of Ninja Turtles) whose powers combine to provide you fully comprehensive powers of search.

1. Forms
2. Results
3. Indexes
4. Drivers
{.c-list-turtles}

## Forms

The search form is the entry point to your site search. Search forms are basic, vanilla HTML forms with a `text` or `search` input named `q` submitting to any URL with a `search:results` tag in its view template.

You can create that page however you wish: it could be an entry, a custom route, or something even fancier we didn't think of.
This [Laracasts video](https://laracasts.com/series/learn-statamic-with-jack/episodes/11) shows how to setup search quickly.

```
<form action="/search/results">
    <input type="search" name="q" placeholder="Search">
    <button type="submit">Go find it!</button>
</form>
```

## Results

Results are powered by the [Search Results](/tags/search) tag. The tag will look for that `q` input sent by the [form](#forms) as a query string in the URL (e.g. `/search/results?q=where's%20the%20beef`).

Inside the tag you have access to all the content and variables from each result.

::tabs

::tab antlers
```antlers
{{ search:results index="default" }}
    {{ if no_results }}
        <h2>No results found for {{ get:q }}.</h2>
    {{ else }}
        <a href="{{ url }}">
            <h2>{{ title }}</h2>
            <p>{{ description | truncate:180 }}</p>
        </a>
    {{ /if }}
{{ /search:results }}
```
::tab blade
```blade
<statamic:search:results
  index="default"
  as="results"
>
  @forelse ($results as $result)
    <a href="{{ $result->url }}">
        <h2>{{ $result->title }}</h2>
        <p>{{ Statamic::modify($result->description)->truncate(180) }}</p>
    </a>
  @empty
    <h2>No results found for {{ get('q') }}.</h2>
  @endforelse
</statamic:search:results>
```
::

The tag has a lot more fine-tuned control available, like renaming the query parameter, filtering on fields and collections, and so on. You can read more about it in the [search results tag](/tags/search) docs.

## Indexes

A search index is an ephemeral copy of your content, optimized for speed and performance while executing search queries. Without indexes, each search would require a scan of every entry in your site. Not an efficient way to go about it, but still technically possible.

Indexes are configured in `config/statamic/search.php` and you can create as many as you want. Each index can hold different pieces of content — and any one piece of content may be stored in any number of indexes.

:::tip
An **index** is a collection of **records**, each representing a single search item. A record might be an entry, a taxonomy term, or even a user.
:::

Your site's default index includes _only_ the title from _all_ collections. The default config looks like this:

``` php
'default' => [
    'driver' => 'local',
    'searchables' => 'content',
    'fields' => ['title'],
],
```

### Search a specific index

The index you wish you to search can be specified as a parameter on your [search results](#results) tag.

::tabs

::tab antlers
```antlers
{{ search:results index="docs" }} ... {{ /search:results }}
```
::tab blade
```blade
<statamic:search:results
  index="docs"
>
  ...
</statamic:search:results>
```
::

### Searchables

The searchables value determines what items are contained in a given index. By passing an array of searchable values you can customize your index however you'd like. For example, to index all blog posts and news articles together, you can do this:

``` php
'searchables' => ['collection:blog', 'collection:news']
```

#### Possible options include:

- `all`
- `collection:*`
- `collection:{collection handle}`
- `taxonomy:{taxonomy handle}`
- `assets:{container handle}`
- `users`
- Custom ones may be added by addons. [Read about creating custom searchables](/extending/search)

### Filtering searchables

You may choose to allow only a subset of searchable items.

For example, you may want to have a toggle field that controls whether an entry gets indexed or not. You can specify a closure with that logic.

```php
'searchables' => ['collection:blog'],
'filter' => function ($item) {
    return $item->status() === 'published' && ! $item->exclude_from_search;
}
```

Now, only published entries that don't have the `exclude_from_search` toggle field enabled will be indexed.


:::tip Heads up
Your filter will override any native filters. For example, entries will filter out drafts by default. If your filter doesn't also remove drafts, they could be indexed.
:::

Alternatively you can specify a class to handle the filtering. This is useful when you want to cache your config using `php artisan config:cache`.

``` php
'filter' => \App\SearchFilters\BlogFilter::class,
```

``` php
namespace App\SearchFilters;

class BlogFilter
{
    public function handle($item)
    {
        return $item->status() === 'published' && ! $item->exclude_from_search;
    }
}
```

### Records & fields

The best practice for creating search indexes is to simplify your record structure as much as possible. Each record should contain only enough information to be discoverable on its own, and no more. You can customize this record by deciding which _fields_ are included in the index.

### Transforming fields

By default, the data in the entry/term/etc that corresponds to the `fields` you've selected will be stored in the index. However, you're able to tailor the values exactly how you want using `transformers`.

Each transformer is a closure that would correspond to a field in your index's `fields` array.

``` php
'fields' => ['title', 'address'],
'transformers' => [

    // Return a value to store in the index.
    'title' => function ($title) {
        return ucfirst($title);
    },

    // Return an array of values to be stored.
    // These will all be separate searchable fields in the index.
    // $value is the current value
    // $searchable is the object that $value has been plucked from
    'address' => function ($value, $searchable) {
        return [
            '_geoloc' => $value['geolocation'],
            'location' => $value['location'],
            'region' => $value['region'],
        ];
    }
]
```

Alternatively you can specify a class to handle the transformation. This is useful when you want to cache your config using `php artisan config:cache`.

``` php
'fields' => ['title', 'address'],
'transformers' => [
    'title' => \App\SearchTransformers\MyTransfomer::class,
]
```

``` php
namespace App\SearchTransformers;

class MyTransformer
{
    public function handle($value, $field, $searchable)
    {
        // $value is the current value
        // $field is the index from the transformers array
        // $searchable is the object that $value has been plucked from

        return ucfirst($value);
    }
}
```

### Updating indexes

Whenever you save an item in the Control Panel it will automatically update any appropriate indexes. If you edit content by hand, you can tell Statamic to scan for new and updated records via the command line.

``` shell
# Select which indexes to update
php please search:update

# Update a specific index
php please search:update name

# Update all indexes
php please search:update --all
```

### Connecting indexes

When a search is performed in the control panel (in collections, taxonomies, or asset containers, for example), Statamic will search the configured index for that content type.

If an index _hasn't_ been defined or specified, Statamic will perform a less efficient, generic search. It'll be slower and less relevant, but better than nothing.

You can define which search index will be used by adding it to the respective YAML config file:

``` yaml
# content/collections/blog.yaml
title: Blog
search_index: blog
```

:::tip About entries
After specifying that an index contains entries from a collection (in [searchables](#searchables)), you **must also** specify the index in the collection config itself because collections and entries can be in multiple indexes.

Also, since draft entries are not included in search indexes by default, you'll want to include them for your collection-linked index. You can add a filter that allows everything.

```php
'articles' => [
    'driver' => 'local',
    'searchables' => ['collection:articles'],
    'filter' => fn () => true, // [tl! ++]
]
```
:::

### Localization

You may choose to use separate indexes to store localized content. For example, English entries go in one index, French entries go in another, and so on.

Take these site and search configs for example:

```yaml
# resources/sites.yaml
en:
  url: /
fr:
  url: /fr/
de:
  url: /de/
```

```php
// config/statamic/search.php
'indexes' => [
    'default' => [
        'driver' => 'local',
        'searchables' => 'content',
    ]
]
```

By default, all entries will go into the `default` index, regardless of what site they're in. You can enable localization by setting the `sites` you want.

```php
'indexes' => [
    'default' => [
        'driver' => 'local',
        'searchables' => 'content',
        'sites' => ['en', 'fr'], // You can also use "all" [tl! ++ **]
    ]
]
```

This will create dynamic indexes named after the specified sites:

- `default_en`
- `default_fr`

If you have a localized index and include searchables that do not support localization (like assets or users), they will appear in each localized index.


## Drivers

Statamic takes a "driver" based approach to search engines. Drivers are interchangeable so you can gain new features or integrate with 3rd party services without ever having to change your data or frontend.

The native [local driver](#local-driver) is simple and requires no additional configuration, while the included [algolia driver](#algolia-driver) makes it super simple to integrate with [Algolia](https://algolia.com), one of the leading search as a service providers.

You can build your own custom search drivers or look at the [Addon Marketplace](https://statamic.com/addons/tags/search) to see what the community has already created.

### Local {#local-driver}

The `local` driver (aka "Comb") uses JSON to store key/value pairs, mapping fields to the content IDs they belong to. It lacks advanced features you would see in a service like Algolia, but hey, It Just Works™. It's a great way to get a search started quickly.

#### Settings

You may provide local driver specific settings in a `settings` array.

```php
'driver' => 'local',
'searchables' => 'content',
// [tl! **:start]
'min_characters' => 3,
'use_stemming' => true,
// [tl! **:end]
```

- `match_weights`: An array of weights for each field to use when calculating relevance scores. Defaults to:
    ```php
    [
        'partial_word' => 1,
        'partial_first_word' => 2,
        'partial_word_start' => 1,
        'partial_first_word_start' => 2,
        'whole_word' => 5,
        'whole_first_word' => 5,
        'partial_whole' => 2,
        'partial_whole_start' => 2,
        'whole' => 10,
    ]
    ```
- `min_characters`: The minimum number of characters required in a search query. Defaults to `1`.
- `min_word_characters`: The minimum number of characters required in a word in a search query. Defaults to `2`.
- `score_threshold`: The minimum score required for a result to be included in the search results. Defaults to `1`.
- `property_weights`: An array of weights for each property to use when calculating relevance scores. Defaults to `[]`.
- `query_mode`: The query mode to use when searching (e.g. "whole", "words", "boolean"). Defaults to `boolean`.
- `use_stemming`: Whether to use stemming when searching (e.g. "jumping" matches "jump"). Defaults to `false`.
- `use_alternates`: Whether to use alternate spellings when searching (e.g. "color" matches "colour"). Defaults to `false`.
- `include_full_query`: Whether to include the full search query in the search results. Defaults to `true`.
- `stop_words`: An array of stop words to exclude from the search query. Defaults to `[]`.
- `limit`: Whether to limit the number of results returned. Defaults to `null`.
- `enable_too_many_results`: Whether to enable a warning when too many results are returned. Defaults to `false`.
- `sort_by_score`: Whether to sort the search results by relevance score. Defaults to `true`.
- `group_by_category`: Whether to group the search results by category. Defaults to `false`.
- `exclude_properties`: An array of properties to exclude from the search results. Defaults to `[]`.
- `include_properties`: An array of properties to include in the search results. Defaults to `[]`.

### Algolia {#algolia-driver}

Algolia is a full-featured search and navigation cloud service. They offer fast and relevant search with results in under 100 ms (99% under 20 ms). Results are prioritized and displayed using a customizable ranking formula.

``` php
'default' => [
    'driver' => 'algolia',
    'searchables' => 'content',
],
```

To set up the Algolia driver, create an account on [their site](https://www.algolia.com/), drop your API credentials into your `.env`, and install the composer dependency.

``` env
ALGOLIA_APP_ID=your-algolia-app-id
ALGOLIA_SECRET=your-algolia-admin-key
```

``` shell
composer require algolia/algoliasearch-client-php:^3.4
```

Statamic will automatically create and sync your indexes as you create and modify entries once you kick off the initial index creation by running the command `php please search:update`.

#### Settings
You may provide Algolia-specific [settings](https://www.algolia.com/doc/api-reference/settings-api-parameters/) in a `settings` array.

```php
'driver' => 'algolia',
'searchables' => 'content',
'settings' => [ // [tl! **:start]
    'attributesForFaceting' => [
        'filterOnly(post_tags)',
        'filterOnly(post_categories)',
    ],
    'customRanking' => [
        'asc(attribute1)',
        'desc(attribute2)',
        'typo',
        'words'
    ]
] // [tl! **:end]
```

#### Templating with Algolia

We recommend using the [Javascript implementation](https://www.algolia.com/doc/api-client/getting-started/install/javascript/?language=javascript) to communicate directly with them for the frontend of your site. This bypasses Statamic entirely in the request lifecycle and is incredibly fast.


## Extras

### Config cascade

You can add values into the defaults array, which will cascade down to all the indexes, regardless of which driver they use.

You can also add values to the drivers array, which will cascade down to any indexes using that respective driver. A good use case for this is to share API credentials across indexes.

Any values you add to an individual index will only be applied there.


## Control Panel

Statamic configures a `cp` search index behind the scenes, used by the Command Palette.

By default, it uses the `local` driver and includes content (entries/terms/assets), users, and any addon-provided searchables.

You can override the configuration in your `search.php` config file:

```php
// config/statamic/search.php

'indexes' => [  

	// ...
  
    'cp' => [  
        'driver' => 'local',  
        'searchables' => ['content', 'users', 'addons'],  
        'fields' => ['title'],
    ],
    
],
```


## Digging deeper

Search is split into a handful of different parts behind the scenes.

- An `Index` class will exist for each configured index. It will know how to send data to and from the underlying driver.
- `Searchable` classes are the things that can be indexed and searched. (e.g. an `Entry`)
- `ProvidesSearchables` classes (or just "Providers") are classes that define all the applicable searchable items. (e.g. an `Entries` provider gives `Entry` instances.)
- `Result` classes are wrappers that allow Statamic to use the searchable objects in a consistent way. (e.g. each result should have an identifier, type, Control Panel URL, etc)


### Custom Searchables

In order to allow searching of custom items, you must create a provider and make your object implement Searchable.

In the following examples, we'll assume you are wanting to store products as Eloquent models.

#### Implement Searchable

The object you want to make searchable should implement both the `Statamic\Contracts\Data\Augmentable` and `Statamic\Contracts\Search\Searchable` interfaces. To make things easier, you can import the `HasAugmentedData` and `Searchable` traits which will handle most of the heavy lifting for you.

```php
use Illuminate\Database\Eloquent\Model;
use Statamic\Contracts\Data\Augmentable;
use Statamic\Contracts\Search\Result as ResultContract;
use Statamic\Contracts\Search\Searchable as SearchableContract;
use Statamic\Data\HasAugmentedData;
use Statamic\Search\Result;
use Statamic\Search\Searchable;

class Product extends Model implements Augmentable, ContainsQueryableValues, SearchableContract
{
    use HasAugmentedData, Searchable;

    /**
     * The identifier that will be used in search indexes.
     */
    public function getSearchReference(): string
    {
        return 'product::'.$this->id;
    }

    /**
     * The indexed value for a given field.
     */
    public function getSearchValue(string $field)
    {
        return $this->$field;
    }

    /**
     * Convert to a search result class.
     * You can use the Result class, or feel free to create your own.
     */
    public function toSearchResult(): ResultContract
    {
        return new Result($this, 'product');
    }

/**
     * Returns an array of the model's attributes to be used in augmentation.
     */
    public function augmentedArrayData()
    {
        return $this->attributesToArray();
    }
}
```

When you're making a searchable from an Eloquent model, you'll need to override some `offset`/`__call` methods to prevent conflicts between Eloquent and Statamic's implementations of those methods:

```php
/**
 * These methods exist on both Eloquent's Model class and in Statamic's HasAugmentedInstance trait.
 * To prevent conflicts, we need to override these methods and force them to call Eloquent's method.
 */

public function offsetGet($offset): mixed
{
    return parent::offsetGet($offset);
}

public function offsetSet($offset, $value): void
{
    parent::offsetSet($offset, $value);
}

public function offsetUnset($offset): void
{
    parent::offsetUnset($offset);
}

public function offsetExists($offset): bool
{
    return parent::offsetExists($offset);
}

public function __call($method, $parameters)
{
    return parent::__call($method, $parameters);
}
```

#### Create Provider

You should have a class that implements `ProvidesSearchables`, however it's even easier for you to extend `Provider`.

```php
use Statamic\Search\Searchables\Provider;

class ProductProvider extends Provider
{
    /**
     * The handle used within search configs.
     *
     * e.g. For 'searchables' => ['collection:blog', 'products:hats', 'users']
     *      they'd be 'collection', 'products', and 'users'.
     */
    protected static $handle = 'products';

    /**
     * The prefix used in each Searchable's reference.
     *
     * e.g. For 'entry::123', it would be 'entry'.
     */
    protected static $referencePrefix = 'product';

    /**
     * Convert an array of keys to the actual objects.
     * The keys will be searchable references with the prefix removed.
     */
    public function find(array $keys): Collection
    {
        return Product::find($keys);
    }

    /**
     * Get all searchables and return a collection of 
     * their references.
     * 
     * e.g. 'entry::123'
     */
    public function provide(): Collection
    {
        return Product::query()
            ->pluck('id')
            ->map(fn ($id) => "product::{$id}");

        // If you wanted to allow subsets of products, you could specify them in your
        // config then retrieve them appropriately here using keys.
        // e.g. 'searchables' => ['products:hats', 'products:shoes'],
        // $this->keys would be ['keys', 'hats'].
        return Product::whereIn('type', $this->keys)
            ->pluck('id')
            ->map(fn ($id) => "product::{$id}");
    }

    /**
     * Check if a given object belongs to this provider.
     */
    public function contains($searchable): bool
    {
        return $searchable instanceof Product;
    }
}
```

#### Register the Provider

In order to use the provider, first register it within a service provider, and then it will be available to your search config by its handle.

```php
use Statamic\Facades\Search;

public function boot()
{
    ProductProvider::register();
}
```

```php
// config/statamic/search.php

'indexes' => [
    'products_and_blog_posts' => [
        'driver' => 'local',
        'searchables' => [
            'products', // [tl! ++]
            'collections:blog'
        ],
        'fields' => ['title']
    ]
]
```

You can also include your searchable in the `content` or `addons` wildcard searchables, which are used by default for front-end and Control Panel searches.

```php
// Pass the handle...
Search::addContentSearchable('product');
Search::addCpSearchable('order');

// Or the provider class...
Search::addContentSearchable(ProductsProvider::class);
Search::addCpSearchable(OrdersProvider::class);
```

#### Event Listeners

You will want to update the indexes when you create, edit, or delete your searchable items.

Continuing with the Eloquent example, we can hook into model events in your service provider.

```php
use Illuminate\Support\Facades\Event;
use Statamic\Facades\Search;

Event::listen('eloquent.saved: App\Models\Product', function ($model) {
    Search::updateWithinIndexes($model);
});

Event::listen('eloquent.deleted: App\Models\Product', function ($model) {
    Search::deleteFromIndexes($model);
});
```

The `updateWithinIndexes` method will update the record in all appropriate indexes. If a filter determines that the record should be removed (e.g. if it changed into a draft), it'll remove it.

The `deleteFromIndexes` method will remove it from all appropriate indexes.

### Custom Index Drivers

Statamic comes with two native search index drivers: Comb and Algolia. Comb is our "local" driver, where indexes are stored as json files. Algolia integrates with the service using their API.

For this example, we'll integrate with a fictional service called FastSearch.

#### Create Index

You should have a class that extends `Index`.

```php
use Statamic\Search\Index;

class FastSearchIndex extends Index
{
    private $client;

    public function __construct(FastSearchClient $client, $name, array $config, string $locale = null)
    {
        // In this example, we'll accept a fictional client class that will perform API requests.
        // If you have a constructor, don't forget to construct the parent class too.
        $this->client = $client;
        parent::__construct($name, $config, $locale);
    }

    /**
     * Return a query builder that will perform the search.
     */
    public function search($query)
    {
        return (new FastSearchQuery($this))->query($query);
    }

    /**
     * Check whether the index actually exists.
     * i.e. Does it exist in the service, or as a json file, etc.
     */
    public function exists()
    {
        $this->client->indexExists($this->name);
    }

    /**
     * Insert items into the index.
     */
    public function insertDocuments(Documents $documents)
    {
        $this->client->insertObjects($documents->all());
    }

    /**
     * Delete an item from the index.
     */
    public function delete($document)
    {
        $this->client->deleteObject($document);
    }

    /**
     * Delete the entire index.
     */
    protected function deleteIndex()
    {
        $this->client->deleteIndex($this->name);
    }
}
```

#### Register Index

```php
public function boot()
{
    Search::extend('fast', function ($app, $config, $name) {
        $client = new FastSearchApiClient('api-key');
        return new FastSearchIndex($client, $name, $config);
    });
}
```

#### Create Query Builder

In the index class, the `search` method wanted a query builder. You can create a class that extends our own, which only requires you to define a single method.

```php
<?php

namespace App\Search;

use Statamic\Search\QueryBuilder;
use Statamic\Support\Str;

class CustomSearchQuery extends QueryBuilder
{
    /**
     * Get search results as an array.
     * e.g. [
     *  ['title' => 'One', 'search_score' => 500],
     *  ['title' => 'Two', 'search_score' => 400],
     * ]
     */
    public function getSearchResults()
    {
        $results = $this->index->searchUsingApi($query);

        // Statamic will expects a search_score to be in each result.
        // Some services like Algolia don't have scores and will just return them in order.
        // This is a trick to set the scores in sequential order, highest first.
        return $results->map(function ($result, $i) use ($results) {
            $result['search_score'] = $results->count() - $i;

            return $result;
        });
    }
}
```

This `getSearchResults` method is used in the parent class in order to allow basic filtering and other query methods. Of course, you are free to build as much of your own query builder as you like.