---
id: d8a8568c-bb93-4e84-8d30-e527b3b02876
blueprint: modifiers
modifier_types:
  - array
  - markup
title: List
---
Turn a simple array into a comma delimited list with no comma after the last item.

```.language-yaml
things:
  - batman
  - zombies
  - scrunchies
```

```
{{ things | list }}
```

```.language-output
batman, zombies, scrunchies
```
