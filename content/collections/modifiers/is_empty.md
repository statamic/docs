---
id: a94a24ce-500d-4194-85db-85fcbb552e06
blueprint: modifiers
modifier_types:
  - array
title: 'Is Empty'
---
Checks an array recursively. It returns `true` for empty arrays and arrays containing only empty strings or other empty arrays. Values such as `null`, `false`, and `0` count as non-empty for this modifier.

```yaml
some_data:
  - is living here
more_data:
  with: ''
  hopes: ''
  and: ''
  dreams:
    - ''
```

::tabs

::tab antlers
```antlers
{{ if some_data | is_empty }}
{{ if more_data | is_empty }}

```
::tab blade
```blade
@if (Statamic::modify($some_data)->isEmpty()->fetch()) ... @endif
@if (Statamic::modify($more_data)->isEmpty()->fetch()) ... @endif
```
::

```html
false
true
```
