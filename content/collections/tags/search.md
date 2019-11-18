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
    name: limit
    type: integer
    description: Limit the total results returned.
  -
    name: offset
    type: integer
    description: Skip the first `n` number of results.
  -
    name: supplement_data
    type: string
    description: >
      When `true` will include all non-indexed content field. Disabling may result in performance increases with the trade-off that only indexed fields will be available. Default: `true`.
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
    name: is_entry
    type: boolean
    description: Whether the current item is an entry.
  -
    name: is_term
    type: boolean
    description: Whether the current item is a taxonomy term.
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
