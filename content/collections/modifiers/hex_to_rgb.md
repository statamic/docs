---
id: 69000ef1-0a98-42a4-ba1a-0bab4c58ca7d
blueprint: modifiers
modifier_types:
  - utility
title: 'Hex To RGB'
---
Converts a color from hex to RGB, the perfect match for the [color fieldtype](/fieldtypes/color).

```yaml
color: `#FF269E`
```

::tabs

::tab antlers
```antlers
{{ color | hex_to_rgb }}
```
::tab blade
```blade
{{ Statamic::modify($color)->hexToRgb() }}
```
::

```html
255, 38, 158
```
