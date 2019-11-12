---
title: Get_Content
parse_content: false
intro: |
  One of the most flexible ways to fetch content from elsewhere in your site is by using the `get_content` tag. Specify a URL and fetch all the data attached to it.
description: Fetch content by URL
parameters:
  -
    name: from
    type: string
    description: Pass a local URL or ID as a string, reference to variable, or pipe delimited list, and all retrieved data will be available inside the tag pair.
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
    type: boolean
    description: 'Enable to include unpublished entries. Default: `false`.'
  -
    name: show_future
    type: boolean
    description: 'Include entries with publish dates in the future, even if the collection has that behavior disabled. Default: `false`'
  -
    name: show_past
    type: boolean
    description: 'Include entries with publish dates in the past, even if the collection has that behavior disabled. Default: `true`'
  -
    name: sort
    type: string
    description: >
      If you're fetching content from multiple URLs, you can sort the results any field handle. Example: `sort="price|desc"`.
  -
    name: locale
    type: string
    description: Show the retrieved content in the selected locale.
stage: 4
id: a33dd9d3-f2f0-4114-b19d-1126361c327e
---
## Overview

Think of this tag as an all-purpose 🇨🇭Swiss Army Knife for fetching content. Give it one or more URLs and you'll receive all the data that would be injected automatically into the view if you visited it directly. It doesn't matter where the data comes from – entry, taxonomy, route, controller, database, etc.

```
{{ get_content from="about/team" }}
  {{ team }}
    <div class="w-1/3">
      <img src="{{ headshot }}" alt="{{ name }}">
      <p>{{ name }}, {{ job_title }}</p>
    </div>
  {{ /team }}
{{ /get_content }}
```

## Shorthand

You may also use a shorthand syntax, where the second tag argument refers to a variable that contains a URL or ID.

```
---
related_by_url: /about
related_by_id: 123-321-abc-defg123
---
{{ get_content:related_by_url }}
  {{ title }}
{{ /get_content:related_by_url }}

{{ get_content:related_by_entry }}
  {{ title }}
{{ /get_content:related_by_entry }}
```
