---
title: Structures
meta_title: 'Entries Fieldtype'
description: 'Create relationships with structures.'
intro: |
  For when you need to create a relationship to one or more [structures](/structures). This could be useful to pick which version of a sidebar or footer to include on a page, or other similar things.

screenshot: fieldtypes/structures.png
options:
  -
    name: max_items
    type: integer
    description: 'The maximum number of items that may be selected. Setting this to `1` will automatically change the UI to a dropdown.'
  -
    name: mode
    type: string
    description: Sets the UI mode for choosing your structures. Pick between `Stack Selector`, `Select Dropdown`, or `Typeahead Field`.
stage: 4
id: 5a55198f-fcb6-4cb1-aacc-4aec3ad45003
---
## Overview

Use this fieldtype to create a one-way relationship with one or more structures in your site. It's a simple-little-helper type of thing.

## Data Structure

This fieldtype will store the handle or handles of the structured collection. They will be augmented in your Antlers templates to work exactly like the [nav](/tags/nav) tag.

``` yaml
shown_structures:
  - main_nav
  - footer
  ```

## Templating

Loop through the structure collecctions with access to all of the entries.

```
<ul>
  {{ shown_structures }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /shown_structures }}
</ul>
```

``` output
<ul>
  <li><a href="/look-at-this">Look at This!</a></li>
  <li><a href="/look-at-that">Wait, Look at That!</a></li>
</ul>
```

## Config Options
