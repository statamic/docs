---
id: fa936f49-be25-432e-9543-7a201a652055
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Insert
---
Inserts a string at the position provided. The beginning of the string is position 0.

```yaml
opinion: This is yummy.
```

::tabs

::tab antlers
```antlers
{{ opinion | insert('not', 8) }}
```
::tab blade
```blade
{{ Statamic::modify($opinion)->insert('not', 8) }}
```
::

```html
This is not yummy.
```
