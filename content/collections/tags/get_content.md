---
title: Get Content
description: Fetches content by URL or ID
intro: |
  It gets content from other entries! Specify a URI or ID and fetch all the data attached to it.
parameters:
  -
    name: from
    type: string
    description: Pass a URI (e.g. `/about`), an ID (e.g. `123`), a pipe delimited list of them (e.g. `123|456`), or a reference to a variable containing them (e.g. `:from="ids"`), and all retrieved data will be available inside the tag pair.
  -
    name: site|locale
    type: string
    description: Show the retrieved content in the selected site.
stage: 4
id: a33dd9d3-f2f0-4114-b19d-1126361c327e
---
## Overview

This tag lets you fetch data from other entries. It's useful if you need to hard-code some dynamic content in your template.

> If you're using a fieldtype like [entries](/fieldtypes/entries) to select which entries you'd like to render, then you don't even need this tag!
> You can simply loop over the selections like this: `{{ your_entries_field }} {{ title }} {{ /your_entries_field }}`

For example, you might want to output some company information from your home page:

```
{{ get_content from="/about/company" }}
  {{ staff }}
    <div class="w-1/3">
      <img src="{{ headshot }}" alt="{{ name }}">
      <p>{{ name }}, {{ job_title }}</p>
    </div>
  {{ /staff }}
{{ /get_content }}
```


## Shorthand

You may also use a shorthand syntax, where the second tag argument refers to a variable that contains a URI or ID.

```
---
related_by_uri: /about
related_by_id: 123-321-abc-defg123
---
{{ get_content:related_by_uri }}
  {{ title }}
{{ /get_content:related_by_uri }}

{{ get_content:related_by_id }}
  {{ title }}
{{ /get_content:related_by_id }}
```
