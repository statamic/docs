---
title: "Collection:Next"
description:  Fetches the next entries in order.
intro: If you're on a single entry page and want to show _next_ entries in order, this is the tag you want. It doesn't matter whether the collection is ordered alphabetically, by date, or manually.
parameters:
  -
    name: in|collection
    type: string
    description: >
      Explicitly define a collection. Defaults to whatever collection the current entry is in.
  -
    name: wrap
    type: boolean
    description: >
      When `true`, will "wrap around" to the other end of the list and return the first entry. Default: `false`.
  -
    name: current
    type: 'string'
    description: >
      Explicitly define a current entry by `id`. Defaults to the current entry in context.
  -
    name: collection params
    type: inheritance
    description: 'All [collection tag](/tags/collection#parameters) parameters are available.'
variables:
  -
    name: no_results
    type: boolean
    description: >
      `true` if no results.
parent_tag: 045a6e54-c792-483a-a109-f07251a79e47
stage: 4
id: 2d66cda0-8765-4fe8-b902-a72de83bcbed
---
## Example

This will show the next 2 posts in a `blog` collection. It'll scope the entries loop into the `posts` tag pair. If there are no more entries, the no results text will be shown.

```
{{ collection:next in="blog" as="posts" limit="2" sort="date:asc" }}

  {{ if no_results }}
    No more posts to read!
  {{ /if }}

  {{ posts }}
    <div class="post">
      <a href="{{ url }}">{{ title }}</a>
    </div>
  {{ /posts }}

{{ /collection:next }}
```

> This functions the same way as the [collection:previous](/tags/collection-previous) tag but in the opposite direction.
