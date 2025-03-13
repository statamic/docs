---
id: 64e41d8f-fedb-4639-bb09-d4e4cbfe3555
blueprint: modifiers
modifier_types:
  - string
title: Trim
---
Returns a string with whitespace removed from the start and end of the string. Supports the removal of unicode whitespace.

```yaml
string: "    This is so sloppy   "
```

::tabs

::tab antlers
```antlers
{{ string | trim }}
```
::tab blade
```blade
{{ Statamic::modify($string)->trim() }}
```
::

```html
This is so sloppy
```
