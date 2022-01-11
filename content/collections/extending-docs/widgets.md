---
title: Building Widgets
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569264107
id: 5900c99f-89b9-4ee3-834c-cb1b070146e4
---

For widgets, start with `php please make:widget examplewidgetname`.

This will automagically set up the widget and create a base template file at `resources/views/widgets/examplewidgetname.blade.php`.

## Configuring

Widgets can be added to the dashboard by modifying the `widgets` array in the `config/statamic/cp.php` file.

``` php
// config/statamic/cp.php
'widgets' => [
  'getting_started',
  [ // [tl! focus:start]
      'type' => 'examplewidgetname',
      'width' => 100,
  ], // [tl! focus:end]
],
```
