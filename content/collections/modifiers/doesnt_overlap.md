---
id: 948e8351-70ba-4263-a3d5-34dfff0551d5
blueprint: modifiers
modifier_types:
  - array
  - conditions
title: "Doesn't Overlap"
---
The inverse of [`overlaps`](/modifiers/overlaps). Returns `true` when _none_ of the needle values are found in the haystack array, otherwise `false`.

The first parameter is the "needle" to compare against the "haystack". It will read from the context if there is a matching variable, otherwise it will use the parameter as the value. The needle can be a single value or an array.

```yaml
shopping_list:
  - eggs
  - flour
  - beef jerky
avoid:
  - kale
  - tofu
```

::tabs

::tab antlers
```antlers
{{ if shopping_list | doesnt_overlap('avoid') }} All clear! {{ /if }}
{{ if shopping_list | doesnt_overlap('flour') }} Nope, there's flour. {{ /if }}
```
::tab blade
```blade
@if (Statamic::modify($shopping_list)->doesntOverlap('avoid')->fetch()) All clear! @endif
@if (Statamic::modify($shopping_list)->doesntOverlap('flour')->fetch()) Nope, there's flour. @endif
```
::

```html
All clear!
```
