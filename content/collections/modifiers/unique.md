---
types:
  - array
  - utility
id: f1486fa5-7cce-4c75-90cd-e131f5f6d184
---
Returns all of the unique items in the array:

```.language-yaml
checklist:
  - zebra
  - hippo
  - hyena
  - giraffe
  - zebra
  - hippo
  - hippo
  - hippo
  - hippo

```

```
{{ checklist | unique | list }}
```

```.language-output
zebra, hippo, hyena, giraffe
```
