---
title: Structures
meta_title: 'Structures Fieldtype'
description: 'Create relationships with structures.'
intro: |
  For when you need to create a relationship to one or more [Structures](/structures). This could be useful to pick which version of a sidebar or footer to include on a page, or other similar things.

screenshot: fieldtypes/screenshots/structures.png
options:
  -
    name: max_items
    type: integer
    description: 'The maximum number of items that may be selected. Setting this to `1` will automatically change the UI to a dropdown.'
  -
    name: mode
    type: string
    description: Sets the UI mode for choosing your structures. Pick between `Stack Selector`, `Select Dropdown`, or `Typeahead Field`.
related_entries:
  - 3c34ef5c-781e-4a22-a09b-25f58bdb58a8
  - ed746608-87f9-448f-bf57-051da132fef7
id: 5a55198f-fcb6-4cb1-aacc-4aec3ad45003
---
## Overview

Use this fieldtype to create a one-way relationship with one or more structures in your site. It's a simple-little-helper type of thing.

:::tip
[Structures](/structures) come in two flavors: Ordered Collections and Navigations.
:::

## Data Storage

The Structures fieldtype stores the `handle` of a single structure as a string, or an array of handles if `max_items` is greater than 1.

``` yaml
structures:
  - main_nav
  - footer
  ```

## Templating

Loop through the structures to  access their handles and pass them to a [Nav](/tags/nav) tag.

::tabs

::tab antlers
```antlers
{{ structures }}
  <ul>
    {{ nav :handle="handle" }}
      <li><a href="{{ url }}">{{ title }}</a></li>
    {{ /nav }}
  </ul>
{{ /structures }}
```
::tab blade
```blade
@foreach ($structures as $nav)
  <ul>
    <statamic:nav
      :handle="$nav"
    >
      <li><a href="{{ $url }}">{{ $title }}</a></li>
    </statamic:nav>
  </ul>
@endforeach
```
::

```html
<ul>
  <li><a href="/look-at-this">Look at This!</a></li>
  <li><a href="/look-at-that">Wait, Look at That!</a></li>
</ul>
```


