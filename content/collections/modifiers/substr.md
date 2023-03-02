---
id: 963d5e43-7bf5-4669-93af-d1990f7f3c97
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Substr
---
Returns the string beginning at a given position with an optional length.
If length not specific, will return the rest of the string.

```yaml
string: How neat is that?
```

```
{{ string | substr(0, 3) }}
{{ string | substr(4, 4) }}
{{ string | substr(-8, 8) }}

```

```html
How
neat
is that?
```
