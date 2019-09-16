---
types:
  - date
  - conditions
id: 22a4460a-b24a-4e24-bd8c-655d03e6d3de
---
Returns `true` if date is on the weekend.

```.language-yaml
date: December 25 2015
```

```
{{ if date | is_weekend }}
```


```.language-output
false
```