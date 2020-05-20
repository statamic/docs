---
modifier_types:
  - utility
id: 12de1a6c-e8be-4703-81a3-fc270311bc84
---
Dump a variable to the browser and see under the hood with data types and array exportation. Definitely just for debugging when in development.

```.language-yaml
food:
  delicious:
    - bacon
    - sushi
```

```
{{ food | dump }}
```

```.language-output
array:2 [▼
  "delicious" => array:2 [▶]
]
```

> You can also use the [dump tag](/tags/dump) to achieve a similar effect.
