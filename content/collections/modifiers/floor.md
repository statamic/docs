---
id: 0dc57cca-67b2-45a1-a02d-915ac64f064f
blueprint: modifiers
modifier_types:
  - math
  - utility
title: Floor
---
Rounds a number down to the next whole number.

```.language-yaml
number: 25.98
```

```
{{ number | floor }}
```

```.language-output
25
```
