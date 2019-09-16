---
types:
  - condition
id: 20ac3e9a-4a45-4c2f-9052-be222fc84016
---
Search a string against multiple needles and return `true` if any are found, otherwise `false`. Case-insensitive.

```.language-yaml
summary: "It was the best of times, it was the worst of times."
```

```
{{ if summary | contains_any:good:better:best }}
```

```.language-output
true
```
