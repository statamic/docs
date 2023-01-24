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
use Statamic\Contracts\Search\Searchable;
use Statamic\Search\Result;

class Product extends Model implements Searchable
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
