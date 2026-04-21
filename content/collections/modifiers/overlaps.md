---
id: d66ba89d-2451-497d-bd6d-37710e9de171
blueprint: modifiers
modifier_types:
  - array
  - conditions
title: Overlaps
---
Check if any values in an array are found in another array. Returns `true` if at least one value matches, otherwise `false`.

The first parameter is the "needle" to find in the "haystack". It will read from the context if there is a matching variable, otherwise it will use the parameter as the value. The needle can be a single value or an array.

This is a loose comparison that mirrors how [`whereJsonOverlaps()`](https://laravel.com/docs/queries#json-where-clauses) works on the query builder side.

```yaml
shopping_list:
  - eggs
  - flour
  - beef jerky
want:
  - eggs
  - oatmeal
```

::tabs

::tab antlers
```antlers
{{ if shopping_list | overlaps('want') }} GOT SOMETHING! {{ /if }}
{{ if shopping_list | overlaps('flour') }} GOT IT! {{ /if }}
{{ if shopping_list | overlaps('kale') }} Not today. {{ /if }}
```
::tab blade
```blade
@if (Statamic::modify($shopping_list)->overlaps('want')->fetch()) GOT SOMETHING! @endif
@if (Statamic::modify($shopping_list)->overlaps('flour')->fetch()) GOT IT! @endif
@if (Statamic::modify($shopping_list)->overlaps('kale')->fetch()) Not today. @endif
```
::

```html
GOT SOMETHING!
GOT IT!
```
