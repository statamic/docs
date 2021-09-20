---
id: ee2da74a-0788-400f-804f-c85ad9b635c0
blueprint: modifiers
modifier_types:
  - array
  - math
title: Sum
---
Returns the sum of all items in an array, optionally specified by a specific key.

```.language-yaml
numbers:
  - 5
  - 10
  - 20
  - 40
stats:
  - player: Luke Skywalker
    score: 750
  - player: Wedge Antilles
    score: 688
  - player: Jar Jar Binks
    score: 1425
```

```
{{ numbers | sum }}
{{ stats | sum:score }}
```

```.language-output
75
2863
```
