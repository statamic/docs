---
id: 40fb38b6-a2b0-411d-b90b-543b38ac8aa3
blueprint: modifiers
modifier_types:
  - string
title: At
---
Returns the single character at a given position in a string. It starts at zero with the first character.

```.language-yaml
title: supercalifragilisticexpialidocious
```

```
{{ title | at:21 }}
```

```.language-output
x
```
