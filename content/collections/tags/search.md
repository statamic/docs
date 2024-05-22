---
title: Search
description: Performs searches and displays matching results
intro: This is how you do search. This is the tag you're looking for.
id: fe8ec156-447d-4f03-974f-0251a8c53244
stage: 1
parameters:
  -
    name: index
    type: string
    description: >
      The search index to query. Default: `default`.
  -
    name: query
    type: 'string'
    description: >
      The query string parameter used for the search term. Default: `q`.
  -
    name: site
    type: string
    required: false
    description: >
      The site you wish to search. If you wish to search in all sites, you can use a wildcard: `*`. Default: the current site.
  -
    name: limit
    type: integer
    description: Limit the total results returned.
  -
    name: offset
    type: integer
    description: Skip the first `n` number of results.
  -
    name: as
    type: string
    description: >
      Alias your results into a new variable loop.
  -
    name: supplement_data
    type: string
    description: >
      When `true` will include all non-indexed content field. See [supplementing data](#supplementing-data) Default: `true`.
  -
    name: for
    type: string
    required: false
    description: 'The term to be searched for. Overrides the `query` parameter.'
  -
    name: paginate
    type: 'boolean|int *false*'
    description: 'Specify whether your results should be paginated. You can pass `true` and also use the `limit` param, or just pass the limit directly in here.'
    required: false
  -
    name: page_name
    type: 'string *page*'
    description: 'The query string variable used to store the page number (ie. `?page=`).'
    required: false
  -
    name: on_each_side
    type: 'int *3*'
    description: When using pagination, this specifies the max number of links each side of the current page. The minimum value is `1`.
  -
    name: chunk
    type: int
    description: 'Chunking results can significantly reduce memory usage when loading lots of results. Specify how many results should be included in each "chunk".'
variables:
  -
    name: no_results
    type: boolean
    description: If there are no results.
  -
    name: first
    type: boolean
    description: If this is the first item in the loop.
  -
    name: last
    type: boolean
    description: If this is the last item in the loop.
  -
    name: count
    type: integer
    description: >
      The number of current iteration in the
      loop.
  -
    name: index
    type: integer
    description: >
      The zero-based count of the current
      iteration in the loop.
  -
    name: total_results
    type: integer
    description: The number of results in the loop.
  -
    name: search_score
    type: float
    description: >
      The internal relevance score that
      Statamic given to this result. Helpful
      for debugging, but useless to the
      public. Only applies when using the local driver.
  -
    name: result_type
    type: string
    description: The type of result. e.g. `entry`, `term`, `asset`, etc.
  -
    name: _highlightResult
    type: array
    description: >
      Available when using the [Algolia driver](https://www.algolia.com/doc/api-client/php/search#fields). Displays a field with the search term automatically highlighted. Example: `{{ _highlightResult:myfield:value }}`

---
## Overview

An overview on how to _configure_ search, indexing, and the query form can be found in the [Search Docs](/search).


## Example

On a search result page, you can loop through the results of the search like they were entries. You'll have access to all the data of all the content of your search results returned so you can format them any way you wish.

```
{{ search:results }}

  {{ if no_results }}
    <h2>No results.</h2>
  {{ else }}

    <a href="{{ url }}" class="result">
      <h2>{{ title }}</h2>
      <p>{{ content | truncate:240 }}</p>
    </a>

  {{ /if }}

{{ /search:results }}
```

## Search Forms

The search form itself — that text box users type into, is a normal, every day HTML form with a `search` input that submits to a URL containing a `search:results` tag in the template. Nice and simple.

```
<form action="/search/results">
    <input type="search" name="q" placeholder="Search">
    <button type="submit">Make it so!</button>
</form>
```

## Supplementing Data

By default, data will be supplemented. This means that while your search indexes can remain lean by only including the fields you actually
want to be searchable, the tag will convert your results into full objects (entries, terms, etc.) which allow you to use any of their fields.

There is an overhead associated with this though, so if all you need is to display values that are in the index, you may disable supplementing.

```
{{ search:results supplement_data="false" }}
```

This has a few caveats:

- Only fields that you've indexed will be available.
- The search tag will filter out any unpublished items by default. If you haven't indexed the `status` field, you will get no results. Either
  index the `status` field, or add `status:is=""` to your tag to prevent the filtering.
- When using multiple sites, the search tag will filter items for the current site. If you haven't indexed the `site` field, you will get no results. Either
  index the `site` field, or add `site:is=""` to your tag to prevent the filtering.
