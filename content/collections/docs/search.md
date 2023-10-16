---
id: 420f083d-99be-4d54-9f81-3c09cb1f97b7
blueprint: page
title: Search
intro: 'Help your visitors find what they''re looking for with search. Use  configurable indexes to configure which fields are important, which aren''t, and fine-tune your way to relevant results.'
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
{.ninja.font-bold}

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

```
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
    'searchables' => 'all',
    'fields' => ['title'],
],
```

### Search a specific index

The index you wish you to search can be specified as a parameter on your [search results](#results) tag.

```
{{ search:results index="docs" }} ... {{ /search:results }}
```

### Searchables

The searchables value determines what items are contained in a given index. By passing an array of searchable values you can customize your index however you'd like. For example, to index all blog posts and news articles together, you can do this:

``` php
'searchables' => ['collection:blog', 'collection:news']
```

#### Possible options include:

- `all`
- `collection:{collection handle}`
- `taxonomy:{taxonomy handle}`
- `assets:{container handle}`
- `users`
- Custom ones may be added by addons. [Read about creating custom searchables](/extending/search)

### Filtering Searchables

You may choose to allow only a subset of searchable items.

For example, you may want to have a toggle field that controls whether an entry gets indexed or not. You can specify a closure with that logic.

```php
'searchables' => ['collection:blog'],
'filter' => function ($item) {
    return $item->status() === 'published' && $item->exclude_from_search;
}
```

Now, only published entries that dont have the `exclude_from_search` toggle field enabled will be indexed.


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
        return $item->status() === 'published' && $item->exclude_from_search;
    }
}
```

### Records & Fields

The best practice for creating search indexes is to simplify your record structure as much as possible. Each record should contain only enough information to be discoverable on its own, and no more. You can customize this record by deciding which _fields_ are included in the index.

### Transforming Fields

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
    'address' => function ($address) {
        return [
            '_geoloc' => $address['geolocation'],
            'location' => $address['location'],
            'region' => $address['region'],
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
        // $searchable is the class that $value has been plucked from

        return ucfirst($value);
    }
}
```

### Updating Indexes

Whenever you save an item in the Control Panel it will automatically update any appropriate indexes. If you edit content by hand, you can tell Statamic to scan for new and updated records via the command line.

``` shell
# Update all indexes
php please search:update

# Update a specific index
php please search:update name
```

### Connecting Indexes

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

```php
// config/statamic/sites.php
'sites' => [
    'en' => ['url' => '/'],
    'fr' => ['url' => '/fr/'],
    'de' => ['url' => '/de/'],
]
```

```php
// config/statamic/search.php
'indexes' => [
    'default' => [
        'driver' => 'local',
        'searchables' => 'all',
    ]
]
```

By default, all entries will go into the `default` index, regardless of what site they're in. You can enable localization by setting the `sites` you want.

```php
'indexes' => [
    'default' => [
        'driver' => 'local',
        'searchables' => 'all',
        'sites' => ['en', 'fr'], // You can also use "all" [tl! ++ **]
    ]
]
```

This will create dynamic indexes named after the specified sites:

- `default_en`
- `default_fr`

If you have a localized index and include searchables that do not support localization (like assets or users), they will appear in each localized index.

### Search Options

The built in search driver supports multiple options you can pass in.

- `match_weights`: An array of weights for each field to use when calculating relevance scores. Defaults to `null`.
- `min_characters`: The minimum number of characters required in a search query. Defaults to `null`.
- `min_word_characters`: The minimum number of characters required in a word in a search query. Defaults to `null`.
- `score_threshold`: The minimum score required for a result to be included in the search results. Defaults to `null`.
- `property_weights`: An array of weights for each property to use when calculating relevance scores. Defaults to `null`.
- `query_mode`: The query mode to use when searching (e.g. "all", "any", "exact"). Defaults to `null`.
- `use_stemming`: Whether to use stemming when searching (e.g. "jumping" matches "jump"). Defaults to `false`.
- `use_alternates`: Whether to use alternate spellings when searching (e.g. "color" matches "colour"). Defaults to `false`.
- `include_full_query`: Whether to include the full search query in the search results. Defaults to `null`.
- `enable_too_many_results`: Whether to enable a warning when too many results are returned. Defaults to `null`.
- `sort_by_score`: Whether to sort the search results by relevance score. Defaults to `null`.
- `exclude_properties`: An array of properties to exclude from the search results. Defaults to `null`.
- `stop_words`: An array of stop words to exclude from the search query. Defaults to `['the', 'a', 'an']`.
- `include_properties`: An array of properties to include in the search results. Defaults to `$this->config['fields'] ?? ['title']`.

## Drivers

Statamic takes a "driver" based approach to search engines. Drivers are interchangeable so you can gain new features or integrate with 3rd party services without ever having to change your data or frontend.

The native [local driver](#local-driver) is simple and requires no additional configuration, while the included [algolia driver](#algolia-driver) makes it super simple to integrate with [Algolia](https://algolia.com), one of the leading search as a service providers.

You can build your own custom search drivers or look at the [Addon Marketplace](https://statamic.com/addons/tags/search) to see what the community has already created.

### Local {#local-driver}

The `local` driver uses JSON to store key/value pairs, mapping fields to the content IDs they belong to. It lacks advanced features like weighting and relevance matching, but hey, It Just Works™. It's a great way to get a search started quickly.

### Algolia {#algolia-driver}

Algolia is a full-featured search and navigation cloud service. They offer fast and relevant search with results in under 100 ms (99% under 20 ms). Results are prioritized and displayed using a customizable ranking formula.

``` php
'default' => [
    'driver' => 'algolia',
    'searchables' => 'all',
],
```

To set up the Algolia driver, create an account on [their site](https://www.algolia.com/), drop your API credentials into your `.env`, and install the composer dependency.

``` env
ALGOLIA_APP_ID=your-algolia-app-id
ALGOLIA_SECRET=your-algolia-admin-key
```

``` shell
composer require algolia/algoliasearch-client-php
```

Statamic will automatically create and sync your indexes as you create and modify entries once you kick off the initial index creation by running the command `php please search:update`.

### Templating with Algolia

We recommend using the [Javascript implementation](https://www.algolia.com/doc/api-client/getting-started/install/javascript/?language=javascript) to communicate directly with them for the frontend of your site. This bypasses Statamic entirely in the request lifecycle and is incredibly fast.


## Extras

### Config Cascade

You can add values into the defaults array, which will cascade down to all the indexes, regardless of which driver they use.

You can also add values to the drivers array, which will cascade down to any indexes using that respective driver. A good use case for this is to share API credentials across indexes.

Any values you add to an individual index will only be applied there.
