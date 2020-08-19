---
title: Taxonomy
overview: Fetch and filter Taxonomy terms.
intro: Taxonomy terms are grouped into taxonomies and are fetched and filtered by this tag. A taxonomy could contain tags, categories, or sock colors.
description: Fetches and filters terms in one or more taxonomies.
stage: 1
parameters:
  -
    name: taxonomy
    type: tag part
    description: 'The taxonomy to use. This is not actually a parameter, but part of the tag itself. For example, `{{ taxonomy:categories }}`'
  -
    name: taxonomy|is|use|from|folder
    type: string
    description: >
      When using the verbose syntax, this is how you specify which taxonomy to use.
  -
    name: min_count
    type: 'integer *0*'
    description: >
      The minimum number of entries a taxonomy term
      must have to show up in the list.
  -
    name: collection
    type: string
    description: >
      Filter the listing by terms that
      only appear in the specified collection.
      You may pipe-separate multiple
      collections.
  -
    name: page
    type: string
    description: >
      Filter the listing by terms that
      only appear in entries mounted to the
      specified page. You may pipe-separate
      multiple pages.
  -
    name: show
    type: string
    description: >
      Set this to `all` to show all taxonomy terms. This will prevent any filtering of the underlying
      content collection. The filtering parameters (`show_unpublished`, `show_future`, etc) will
      all be ignored.
  -
    name: show_unpublished
    type: 'boolean *false*'
    description: >
      Allow unpublished content in the
      underlying collection.
  -
    name: show_future
    type: 'boolean *false*'
    description: >
      Allow date-based entries with future
      dates in the underlying collection.
  -
    name: show_past
    type: 'boolean *true*'
    description: >
      Just like `show_future`, but with
      content in the past.
  -
    name: since
    type: string/var
    description: "Limits the date the earliest point in time from which date-based entries should be fetched. You can use plain English (PHP's `strtotime` method will interprit. eg. `last sunday`, `january 15th, 2013`, `yesterday`) or the name any date variable."
  -
    name: until
    type: string/var
    description: >
      The inverse of `since`, but sets the _max_
      date.
  -
    name: sort
    type: 'string *results*'
    description: >
      Sort entries by a field. By default it
      will be sorted by the number of results
      for each taxonomy.
  -
    name: filter
    type: wizardry
    description: >
      Filter the listing by either a custom
      class or using a special syntax, both of
      which are outlined in more detail below.
variables:
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
    name: results
    type: integer
    description: >
      The number of times the taxonomy has
      been used.
  -
    name: taxonomy data
    type: mixed
    description: >
      Each taxonomy being iterated has access
      to all the variables inside that
      taxonomy. This includes things like
      `title`, `content`, etc.
  -
    name: collection
    type: array
    description: >
      An array containing all the content that
      is associated with the particular
      taxonomy. More details below.
id: ba832b71-a567-491c-b1a3-3b3fae214703
---
## Example {#example}


A basic example would be to loop through the terms in a tags taxonomy and link to each individual tag:

```
<ul>
{{ taxonomy from="tags" }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /taxonomy }}
</ul>
```

You can also use the shorthand syntax for this. We prefer this style ourselves.

```
<ul>
{{ taxonomy:tags }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /taxonomy:tags }}
</ul>
```

If you'd like to fetch tags from multiple taxonomies, you'll need to use the standard syntax.

```
{{ taxonomy from="tags|categories" }}
```

To get terms from _all_ taxonomies, use the wildcard `*`. You may also exclude taxonomies when doing this.

```
{{ taxonomy from="*" not_from="tags" }}
```

## Entries

The `taxonomy` tag allows you to iterate over taxonomy terms, but in each iteration, you also have access to all the corresponding content.

```
{{ taxonomy:categories }}
  <h2>{{ title }}</h2>
  <ul>
    {{ entries }}
      <li><a href="{{ url }}">{{ title }}</a></li>
    {{ /entries }}
  </ul>
{{ /taxonomy:categories }}
```

``` .language-output
<h2>News</h2>
<ul>
  <li><a href="/blog/breaking">A breaking story!</a></li>
  <li><a href="/blog/so-interesting">An interesting article</a></li>
</ul>

<h2>Events</h2>
<ul>
  <li><a href="/events/walk-in-the-park">A walk in the park</a></li>
  <li><a href="/events/summer-camp">Summer camp</a></li>
</ul>
```

## Filtering

There are a couple of ways to filter your taxonomy terms. There's the conditions syntax for filtering by fields, or the custom filter class if you need extra control.

### Conditions

Want to get entries where the title has the words "awesome" and "thing", and "joe" is the author? You can write it how you'd say it:

```
{{ taxonomy:tags
   title:contains="awesome"
   title:contains="thing"
   author:is="joe"
}}
```

There are a bunch of conditions available to you, like `:is`, `:isnt`, `:contains`, `:starts_with`, and `:is_before`. There are many more than that. In fact, there's a whole page dedicated to [conditions - check them out][conditions].


### Custom Query Scopes

Doing something custom or complicated? You can create [query scopes](/extending/query-scopes-and-filters) to narrow down those results.



[conditions]: /conditions
[custom_filters]: /addons/classes/filters
