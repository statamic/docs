---
title: Toggle
description: A toggle switch for booleans (`true` and `false`).
intro: A nice little toggle switch generally used to manage settings-type variables. It stores `true` or `false` and is delightfully uncomplicated, just like our relationship with yogurt.
screenshot: fieldtypes/screenshots/v4/toggle.png
id: ac5f8f98-616f-4621-a7ee-dbc8bbc15525
---
## Data Structure

Flicking the toggle to the right sets to the value to `true`, left to `false`.

``` yaml
do_the_thing: true
```

## Templating

Toggles are usually used to control logic, so you can combine them with `{{ if }}` statements in your templates to handle all manner of show/hide wizardry.

```
{{ if do_the_thing }} It does it {{ /if }}
```
