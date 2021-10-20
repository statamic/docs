---
id: 5166ff7e-2fad-414c-b232-f04108c08900
blueprint: modifiers
modifier_types:
  - math
  - utility
title: Round
---
Rounds a number to a specified precision (number of digits after the decimal point). Defaults to `0`, or whole numbers.

```yaml
pi: 3.14159265359
```

```
{{ pi | round }}
{{ pi | round:2 }}
```

```html
3
3.14
```
