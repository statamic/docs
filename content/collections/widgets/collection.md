---
id: 65652195-52db-4622-a08a-448785a829db
blueprint: widgets
title: 'Collection Widget'
intro: 'Display a list of entries from a collection.'
options:
  -
    name: collection
    type: string
    required: true
    description: 'The collection''s handle.'
  -
    name: width
    type: int
    required: false
    description: 'Width of dashboard area as a percentage. Accepts `25`, `33`, `50`, `66`, `75` and `100`.'
  -
    name: sites
    type: array
    required: false
    description: 'Determines the sites in which this widget should be displayed.'
  -
    name: limit
    type: int
    required: false
    description: 'Limit number of entries. **Default: 5**.'
  -
    name: sort
    type: string
    required: false
    description: 'Sort and order by field name. E.g. `''title:desc''`. Defaults to the collection''s settings.'
  -
    name: fields
    type: array
    required: false
    description: 'An array of field handles to be displayed as columns in the widget.'
  -
    name: title
    type: string
    required: false
    description: 'The title of the widget. Defaults to the collection name.'
  -
    name: show_table_header
    type: boolean
    required: false
    description: 'Show table column headers. Off by default.'
screenshot: widgets/collection-v6.webp
screenshot_dark: widgets/collection-v6-dark.webp
nav_title: Collection
---
## Configuring

Widgets can be added to the dashboard by modifying the `widgets` array in the `config/statamic/cp.php` file.

``` php
// config/statamic/cp.php

'widgets' => [
  [ // [tl! focus:start]
      'type' => 'collection',
      'collection' => 'blog',
      'limit' => 10,
  ], // [tl! focus:end]
],
