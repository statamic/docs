---
id: 62cb634b-06dd-4751-8d4f-3dd141d953e7
blueprint: widgets
title: 'Updater Widget'
intro: 'Shows if there are any Statamic core or addon updates available.'
nav_title: Updater
screenshot: widgets/updater.png
options:
  -
    name: width
    type: int
    required: false
    description: 'Width of dashboard area as a percentage.'
---
## Configuring

Widgets can be added to the dashboard by modifying the `widgets` array in the `config/statamic/cp.php` file.

``` php
// config/statamic/cp.php

'widgets' => [
  'getting_started',
  [ // [tl! focus:start]
      'type' => 'updater',
      'width' => 100,
  ], // [tl! focus:end]
],
