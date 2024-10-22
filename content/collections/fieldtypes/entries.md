---
title: Entries
meta_title: 'Entries Fieldtype'
description: 'Create relationships with other entries.'
intro: |
  Create relationships with other entries in one or more collections. It's not very much like online dating because you can create and link the entries on the fly without leaving the page.
screenshot: fieldtypes/screenshots/entries.png
options:
  -
    name: collections
    type: array
    description: |
      Configure which collections you want to allow relationships with.
  -
    name: max_items
    type: integer
    description: >
      The maximum number of items that may be selected. Setting this to `1` will change the UI to a dropdown.
  -
    name: mode
    type: string
    description: |
        Set the UI style for this field. Can be one of 'default' (Stack Selector), 'select' (Select Dropdown) or 'typeahead' (Typeahead Field).
  -
    name: query_scopes
    type: string
    description: >
      Allows you to specify a [query scope](/extending/query-scopes-and-filters#scopes) which should be applied when retrieving selectable assets. You should specify the query scope's handle, which is usually the name of the class in snake case. For example: `MyAwesomeScope` would be `my_awesome_scope`.
  -
    name: search_index
    type: string
    description: >
        Allows you to specify a [search index](/search#indexes) to be used when searching for entries.
id: acee879a-c832-449d-a714-c57ea5862717
---
## Overview

Use this fieldtype to create a one-way relationship with entries of any collection in your site. It's delightfully simple.

:::watch https://youtube.com/embed/WWbsM5u9afc
Watch how to build a "Related Articles" feature using the Entries Fieldtype
:::

## Data Structure

This fieldtype will store an array of ids to the selected entries. They will be augmented in your Antlers templates to give you access to each entry's data.

``` yaml
related_entries:
  - 12f9be1f-a12e-4680-b769-639d2d1f1d14
  - ea48926d-bf67-4d45-9420-9627a31c37fb
  ```

## Templating

Loop through the entries and do anything you want with the data.

::tabs

::tab antlers
```antlers
<ul>
  {{ related_entries }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /related_entries }}
</ul>
```

::tab blade
```blade
<ul>
  @foreach ($entries as $entry)
    <li><a href="{{ $entry->url }}">{{ $entry->title }}</a></li>
  @endforeach
</ul>
```

::

```html
<ul>
  <li><a href="/look-at-this">Look at This!</a></li>
  <li><a href="/look-at-that">Wait, Look at That!</a></li>
</ul>
```
