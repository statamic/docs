---
title: Next
overview: Grab the next Pages relative to your current Page.
parameters:
  -
    name: from|folder|url
    type: string
    description: >
      The name of the page to search within. When
      left blank, the current URL's parent will be used.
      In most cases, it makes sense to leave this blank.
  -
    name: wrap
    type: 'boolean *false*'
    description: >
      When set to `true`, this tag will wrap
      around to the other end of the list. In
      scenarios where there wouldn’t be a
      next page, the first page will be
      returned.
  -
    name: current
    type: 'string *current url*'
    description: >
      The URL for the piece of content that is
      considered to be “current.” (This
      tag will display the next pages in the
      list after the current one, if one
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
id: b806cc19-c88e-415a-8f2a-d731c9b8832e
---
## Example {#example}

This will show the next 2 pages sibling pages. It'll scope the loop into the `stories` tag pair. If there are no more pages, the no results text will be shown.

```
{{ pages:next as="stories" limit="2" }}

  {{ if no_results }}
    No more stories to read!
  {{ /if }}

  {{ stories }}
    <div class="story">
      <a href="{{ url }}">{{ title }}</a>
    </div>
  {{ /stories }}

{{ /pages:next }}
```

Note: When using `as`, don't use `as="pages"` since it will assume you are trying to use the [Pages Tag](/tags/pages).
