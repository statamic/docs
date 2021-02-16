---
title: Search
intro: Help your visitors find what they're looking for with search. Use  configurable indexes to fine tune what fields are important, which aren't, and keep results relevant.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568644905
id: 420f083d-99be-4d54-9f81-3c09cb1f97b7
blueprint: page
stage: 1
---
## Overview

There are three components — coincidentally the same number of Hanson brothers — whose powers combine to provide you the power of search. The form, the index, and the driver.

## Search Forms

The search form is the most visible part of your site search. Create a normal, every day HTML form with a `search` input and have it submit to any URL containing a `search:results` tag in your template. This is usually — but not always — found in the nav.

```
<form action="/search/results">
    <input type="search" name="q" placeholder="Search">
    <button type="submit">Make it so!</button>
</form>
```

Next, set up the search _results_. You'll have access to all the content and variables inside each result.

```
{{ search:results }}
    {{ if no_results }}
        <h2>No results.</h2>
    {{ else }}
        <a href="{{ url }}">
            <h2>{{ title }}</h2>
            <p>{{ description | truncate:180 }}</p>
        </a>
    {{ /if }}
{{ /search:results }}
```

The tag assumes you're passing the search string through as a GET parameter as we've shown above. You'll see it in the address bar: `/search/results?q=where's%20the%20beef`.

The tag has a lot more fine-tuned control available, like renaming the query parameter, filtering fields and collections, and so on. You can read more about it in the [search results tag](/tags/search) docs.

## Indexes

A search index is a copy of your data stored in a search-friendly format and used for optimizing speed and performance when executing a search query. Without an index, each search would need to scan every entry in your site. Hardly an efficient way to go about it.

Indexes are configured in `config/statamic/search.php` and you can have as many as you'd like. Each holds different pieces of content — and a piece of content may be stored in multiple indexes.

> An **index** is a collection of **records**, each representing a single search item. A record might be an entry, a taxonomy term, or even a user.

Your site's default index includes _only_ the title from from _all_ collections. Its config looks like this:

``` php
'default' => [
    'driver' => 'local',
    'searchables' => 'all',
    'fields' => ['title'],
],
```

## Search a specific Index
To search a specific index, add an `index` parameter to your `search:results` tag.
```
{{ search:results index="my_index" }} ... {{ /search:results }}
```

### Searchables

The searchables value determines what items are contained in a given index. By passing an array of searchable values you can customize your index however you'd like. For example, to index all blog posts and news articles together, you could do this:

``` php
'searchables' => ['collection:blog', 'collection:news']
```

#### Possible options include:

- `all`
- `collection:{collection handle}`
- `taxonomy:{taxonomy handle}`
- `assets:{container handle}`
- `users`

### Records & Fields

The general rule for creating a searchable index is to simplify your record structure as much as possible. Each record should contain enough information to be discoverable on its own, and no more. You can customize this record by deciding which _fields_ are included in the index.

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
        ]
    }
]
```

### Updating Indexes

Whenever you save an item in the Control Panel it will automatically update any appropriate indexes. If you edit content by hand you can insert records and update the index via command line.

``` bash
# Update all indexes
php please search:update

# Update a specific index
php please search:update name
```

### Connecting Indexes

When you perform a search in the control panel in either collections, taxonomies, or asset containers, Statamic will search in their selected index.

(If an index hasn't been specified, Statamic will still perform a "search" but it will be using a less efficient query - not an actual search.)

You can define which search index will be used by adding it to the respective YAML file:

``` yaml
# content/collections/blog.yaml
title: Blog
search_index: blog
```

> Even if you specify that an index contains entries from a collection (in [searchables](#searchables)), you still need to specify the index
> in the collection. This is because it's perfectly acceptable for entries in one collection to be available in multiple indexes.


## Drivers

Statamic takes a driver-based approach to search engines. The native "local" is simple and requires no additional configuration, while Algolia and custom drivers provide features and capabilities going well beyond our core feature set.

### Local

It uses JSON files to store indexes and will perform searches against them. It lacks advanced features like weighting and relevance matching, but hey. It Just Works™. It's a good way to get started quickly.

### Algolia

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

``` bash
composer require algolia/algoliasearch-client-php
```

Statamic will automatically create and sync your indexes as you create and modify entries, but to get the initial index created on Algolia, run `php please search:update`.

### Templating with Algolia

We recommend using the [Javascript implementation](https://www.algolia.com/doc/api-client/getting-started/install/javascript/?language=javascript) to communicate directly with them for the frontend of your site, as this will be incredibly fast, and avoids using Statamic as a middleman.


## Extras

### Config Cascade

You can add values into the defaults array, which will cascade down to all the indexes, regardless of which driver they use.

Then you can add values into the drivers array, which will cascade down to any indexes using the respective driver. A good use case for this is to share API credentials across indexes.

Of course, any values you add to an individual index will only be applied there.
