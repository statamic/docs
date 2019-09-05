---
title: Search
overview: Perform searches and display results in your templates.
id: fe8ec156-447d-4f03-974f-0251a8c53244
parameters:
  -
    name: fields
    type: array
    description: |
      Narrow down your search by looking in specific fields. The fields you select must be located in the corresponding index. You can pipe-separate multiple fields, eg. `title|content`.
      
      Note: If you're using Algolia and have set up searchable attributes, you may only specify fields exist in there.
      Any additional fields will cause you the search tag to yield no results.
  -
    name: collection
    type: string
    description: >
      The name of a collection, to search through its index. If this parameter is not provided, the default index will be used.
  -
    name: param
    type: 'string *q*'
    description: >
      The query string parameter used for the
      search term.
  -
    name: supplement_data
    type: 'string *true*'
    description: >
      When this is `true` it will convert search results to the appropriate content objects, which makes all their fields available in your templates. Disabling this will result in a performance increase, but only indexed fields will be available.
  -
    name: supplement_taxonomies
    type: boolean *true*
    description: >
      By default, Statamic will convert taxonomy term values into actual term objects that you may loop through.
      This has some performance overhead, so you may disable this for a speed boost if taxonomies aren't necessary.
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
    name: content data
    type: array
    description: >
      Each page being iterated has access to all the variables inside that page. This includes things like `title`, `content`, etc. When the `supplement_data` parameter has been set to `false`, only indexed fields will be available.
  -
    name: is_page
    type: boolean
    description: Whether the current item is a page.
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
      When using the Algolia driver, this array will be available as per their [documentation][doc]. You can use this to output a field with the search term automatically highlighted. eg. `{{ _highlightResult:myfield:value }}`

      [doc]: https://www.algolia.com/doc/api-client/php/search#fields

---
## Overview {#overview}

An overview on how to _configure_ search, indexing, and the query form can be found in the [Search Docs](/search).


## Example {#example}

On a search result page, you can loop through the results of the search like they were entries or pages. Because they are. You'll have access to all the data of all the content returned so you can format your results however you'd like. In this example, we're displaying a truncated version of the `content` field.

```
{{ search:results }}

  {{ if no_results }}
    <h2>No results.</h2>
  {{ else }}

    <a href="{{ url }}" class="result">
      <h2>{{ title }}</h2>
      <p>{{ content strip_tags="img|a|p" safe_truncate="180|..." }}</p>
    </a>
    
  {{ /if }}

{{ /search:results }}
```
