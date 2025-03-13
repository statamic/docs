---
id: 02db0ee5-585b-4e40-ab2b-f15a596b341c
blueprint: modifiers
modifier_types:
  - string
  - conditions
title: 'Is Numeric'
---
Returns `true` if variable is a number or numeric string.

```yaml
sequence: 4815162342
another_sequence: just type 4 8 15 16 23 42
```

::tabs

::tab antlers
```antlers
{{ if sequence | is_numeric }}
{{ if another_sequence | is_numeric }}
```
::tab blade
```blade
@if (Statamic::modify($sequence)->isNumeric()->fetch()) ... @endif
@if (Statamic::modify($another_sequence)->isNumeric()->fetch()) ... @endif
```
::

```html
true
false
```
