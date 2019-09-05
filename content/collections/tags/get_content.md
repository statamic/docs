---
title: Get Content
id: a33dd9d3-f2f0-4114-b19d-1126361c327e
parse_content: false
overview: |
  With nothing but a URI, or list of URIs, you can fetch all available data regardless of the content type. It is a friend to pages, entries, and taxonomies alike.
description: Fetch data by one or more URLs regardless of content type.
parameters:
  -
    name: from
    type: string
    description: Pass a local URI or ID as a literal string, variable, or pipe delimited list, and all retrieved data will be available inside the tag pair.
  -
    name: limit
    type: integer
    description: Limit the total results when fetching multiple content files.
  -
    name: offset
    type: integer
    description: Offset the total results when fetching multiple content files.
  -
    name: show_unpublished
    type: boolean *false*
    description: Unpublished content is, by it's very nature, unpublished. That is, unless you show it by turning on this parameter.
  -
    name: show_future
    type: boolean *false*
    description: Date-based entries from the future are excluded from results by default. Of course, if you want to show upcoming events or similar content, flip this switch.
  -
    name: show_past
    type: boolean *true*
    description: Date-based entries from the past are included in results by default.
  -
    name: sort
    type: any fieldname
    description: Sort results by any fieldname when fetching multiple content files.
  -
    name: locale
    type: string
    description: Show the retrieved content in the selected locale.
---
## Example {#example}

Let's use the Redwood demo site as an example. Say we want to fetch the Niles Peppertrout's "Fun Facts" and display a random one in the footer of our site.
If we looked at the `about/index.md` page we would see that there's a variable list called `fun_facts`. That's what we want.

In addition to the `get_content` tag, we'll be using the [shuffle](#) and [limit](#) modifiers to get one item from the list at random, and the [join](#) modifier to collapse an array into a string. This is just one of many ways you could achieve the same result.

```
{{ get_content from="/about" }}
  <blockquote>
    {{ fun_facts | shuffle | limit:1 | join }}
  </blockquote>
{{ /get_content }}
```

### Shorthand syntax

You may also use a shorthand syntax, where the second tag part refers to a variable. This variable should hold the URL or
ID of the content you're fetching.

``` .language-yaml
page: /about
```

```
{{ get_content:page }}
   ...
{{ /get_content:page }}
```

