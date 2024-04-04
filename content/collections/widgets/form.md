---
id: 07520b92-0fe2-44ef-ad1b-d9764b99dba7
blueprint: widgets
title: 'Form Widget'
intro: 'Display a list of the most recent form submissions.'
nav_title: Form
options:
  -
    name: form
    type: string
    required: true
    description: 'The form''s handle.'
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
    description: 'Limit number of submissions. **Default: 5**.'
  -
    name: fields
    type: array
    required: false
    description: 'An array of field handles to include in the list.'
screenshot: widgets/form.png
---
## Configuring

Widgets can be added to the dashboard by modifying the `widgets` array in the `config/statamic/cp.php` file.

``` php
// config/statamic/cp.php

'widgets' => [
  'getting_started',
  [ // [tl! focus:start]
      'type' => 'form',
      'form' => 'contact',
      'fields' => ['name', 'email'],
      'limit' => 10,
  ], // [tl! focus:end]
],
