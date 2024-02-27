---
id: 69000ef1-0a98-42a4-ba1a-0bab4c58ca7d
blueprint: modifiers
modifier_types:
  - utility
title: 'Hex To RGB'
duplicated_from: 2d555b32-e68c-4f9b-8570-f2e8d185989b
---
Converts a color from hex to RGB, the perfect match for the [color fieldtype](/fieldtypes/color).

```yaml
color: #FF269E
```

```
{{ color | hex_to_rgb }}
```

```html
255, 38, 158
```