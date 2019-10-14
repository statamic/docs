---
title: Toggle
description: A toggle switch that manages booleans (`true` and `false`).
intro: A nice little toggle switch generally used to manage settings-type variables. It stores `true` or `false` and is delightfully uncomplicated, just like our relationship with yogurt.
screenshot: fieldtypes/toggle.png
stage: 4
id: ac5f8f98-616f-4621-a7ee-dbc8bbc15525
---
## Data Structure

Flicking the toggle to the right sets to the value to `true`, left to `false`.

``` yaml
should_it: true
```

## Templating

Toggles are usually used to control logic, so you can combine them with `{{ if }}` statements in your templates to do all manner of wizardy.

```
{{ if should_it }} It does {{ /if }}
```
