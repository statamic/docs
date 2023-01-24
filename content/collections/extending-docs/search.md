---
id: 0eedd0bb-81a7-4813-b29f-672fe6697021
blueprint: page
title: Search
intro: 'Statamic comes with its own native drivers and searchables, but you may add your own.'
---

## Overview

Search is split into a handful of different parts behind the scenes.

- An `Index` class will exist for each configured index. It will know how to send data to and from the underlying driver.
- `Searchable` classes are the things that can be indexed and searched. (e.g. an `Entry`)
- `ProvidesSearchables` classes (or just "Providers") are classes that define all the applicable searchable items. (e.g. an `Entries` provider gives `Entry` instances.)
- `Result` classes are wrappers that allow Statamic to use the searchable objects in a consistent way. (e.g. each result should have an identifier, type, Control Panel URL, etc)


## Custom Searchables

In order to allow searching of custom items, you must create a provider and make your object implement Searchable.

In the following examples, we'll assume you are wanting to store products as Eloquent models.

### Implement Searchable

The object you want to make searchable should implement the `Statamic\Contracts\Search\Searchable` interface.

There is a `Searchable` trait to make implementing it easier.

```php
use Statamic\Contracts\Search\Result as ResultContract;
use Statamic\Contracts\Search\Searchable as SearchableContract;
use Statamic\Search\Searchable;
use Statamic\Search\Result;

class Product extends Model implements SearchableContract
{
    use Searchable;

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
}
```

### Create Provider

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
     * Get a collection of all searchables.
     */
    public function provide(): Collection
    {
        return Product::all();

        // If you wanted to allow subsets of products, you could specify them in your
        // config then retrieve them appropriately here using keys.
        // e.g. 'searchables' => ['products:hats', 'products:shoes'],
        // $this->keys would be ['keys', 'hats'].
        return Product::whereIn('type', $this->keys)->get();
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

### Register the Provider

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

## Custom Index Drivers

Statamic comes with two native search index drivers: Comb and Algolia. Comb is our "local" driver, where indexes are stored as json files. Algolia integrates with the service using their API.

For this example, we'll integrate with a fictional service called FastSearch.

### Create Index

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
    protected function insertDocuments(Documents $documents)
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

### Register Index

```php
public function boot()
{
    Search::extend('fast', function ($app, $config, $name) {
        $client = new FastSearchApiClient('api-key');
        return new FastSearchIndex($client, $name, $config);
    });
}
```

### Create Query Builder

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
