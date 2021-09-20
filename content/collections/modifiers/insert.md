---
id: fa936f49-be25-432e-9543-7a201a652055
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Insert
---
Inserts a string at the position provided. The beginning of the string is position 0.

```.language-yaml
opinion: This is yummy.
```

```
{{ opinion insert="not |8" }}
```

```.language-output
This is not yummy.
```
