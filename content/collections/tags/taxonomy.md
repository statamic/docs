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
    name: sort
    type: 'string *title*'
    description: >
      Sort terms by a field. By default it will be sorted by the title. Also available is `entries_count` if you wanted to sort by the most popular terms.
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
    name: entries_count
    type: integer
    description: >
      The number of entries taxonomized by this term.
  -
    name: taxonomy data
    type: mixed
    description: >
      Each taxonomy being iterated has access
      to all the variables inside that
      taxonomy. This includes things like
      `title`, `content`, etc.
  -
    name: entries
    type: query builder
    description: >
      If you use this as a tag pair, you can loop through entries associated with the term. See [entries](#entries) above.
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

You're free to use use filtering or sorting parameters on the `entries` pair that you'd find on the [collection tag](/tags/collection).

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
