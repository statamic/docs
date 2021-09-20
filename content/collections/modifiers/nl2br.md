---
id: ecbf79c1-be5d-412e-a677-30a847cfffa6
blueprint: modifiers
modifier_types:
  - string
  - markup
attributes: true
title: Nl2br
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
