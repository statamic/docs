---
modifier_types:
  - array
id: a7b58312-3498-4807-b2bc-6fcb640fe231
---
Count the number of items in an array.

```.language-yaml
fruit:
  - apples
  - bananas
  - bacon
```

```
{{ fruit | count }}
```

```.language-output
3
```

