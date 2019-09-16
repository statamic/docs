---
types:
  - string
  - markup
attributes: true
id: ecbf79c1-be5d-412e-a677-30a847cfffa6
---
Replaces line breaks with `<br>` tags.

```.language-yaml
summary: |
  This is a summary
  on multiple lines
```

```
{{ summary | nl2br }}
```

```.language-output
This is a summary
on multiple lines
```
