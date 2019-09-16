---
types:
  - array
  - utility
id: ea17da24-79b9-4ac7-84ba-660b29f95899
---
Collapses an array of arrays into a flat array. If duplicate keys exist they *will* get stomped over.

```.language-yaml
numbers:
  - [one, two, three]
  - [four, five, six]
```

```
{{ numbers | collapse }}
```

```.language-yaml
numbers:
  - one
  - two
  - three
  - four
  - five
  - six
```