---
id: c3214196-3d0d-4a3d-b6c3-1ee4960cfe5d
blueprint: modifiers
modifier_types:
  - utility
title: 'To Json'
---
Converts any variable into JSON.

```.language-yaml
stats:
  - player: Luke Skywalker
    score: 750
  - player: Wedge Antilles
    score: 688
  - player: Jar Jar Binks
    score: 1425
```

```
{{ stats | to_json }}
```

```.language-output
[
  {"player":"Luke Skywalker","score":750},
  {"player":"Wedge Antilles","score":688},
  {"player":"Jar Jar Binks","score":1425}
]
```
