---
title: Navs
meta_title: 'Navs Fieldtype'
description: Choose from one or more navigations.
overview: Allows you to choose from one or more navigations.
screenshot: fieldtypes/screenshots/navs.png
options:
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
    name: structure_types
    type: array
    description: >
        Configure which types of structures you want to be selectable. Options are `collection` or `navigation`.
id: 0669f781-bc12-44ff-bbbb-921b80aaf4f3
---
## Overview

Use this fieldtype to create a one-way relationship with one or more navigations in your site. It's a simple-little-helper type of thing.

## Data Structure

The Navs fieldtype stores the `handle` of a single navigation as a string, or an array of handles if `max_items` is greater than 1.

``` yaml
navigations:
  - main_nav
  - footer
  ```

## Templating

Loop through the structures to  access their handles and pass them to a [Nav](/tags/nav) tag.

```
{{ structures }}
  <ul>
    {{ nav :handle="handle" }}
      <li><a href="{{ url }}">{{ title }}</a></li>
    {{ /nav }}
  </ul>
{{ /structures }}
```

```html
<ul>
  <li><a href="/look-at-this">Look at This!</a></li>
  <li><a href="/look-at-that">Wait, Look at That!</a></li>
</ul>
```
