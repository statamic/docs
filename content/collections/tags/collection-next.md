---
title: Next
overview:  Grab the next entries relative to current entry in a Collection.
parameters:
  -
    name: in|collection
    type: string
    description: >
      The name of the collection to search
      within.
  -
    name: wrap
    type: 'boolean *false*'
    description: >
      When set to `true`, this tag will wrap
      around to the other end of the list. In
      scenarios where there wouldn’t be a
      next entry, the first entry will be
      returned.
  -
    name: current
    type: 'string *current url*'
    description: >
      The URL for the piece of content that is
      considered to be “current.” (This
      tag will display the next entries in the
      listing after the current one, if one
      exists.)
  -
    name: collection params
    type: inheritance
    description: 'All parameters available on the [collection tag](/tags/collection) are also available here.'
variables:
  -
    name: no_results
    type: boolean
    description: >
      This will be `true` if there are no
      results.
parent_tag: 045a6e54-c792-483a-a109-f07251a79e47
id: 2d66cda0-8765-4fe8-b902-a72de83bcbed
---
## Example {#example}

This will show the next 2 posts in the `blog` collection. It'll scope the entries loop into the `posts` tag pair. If there are no more entries, the no results text will be shown.

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
