---
id: 3ef1e731-742e-48c2-81f0-6fa916ecda0a
blueprint: modifiers
modifier_types:
  - markup
  - string
  - utility
title: First
---
Returns the first X characters of a string, where X is any positive integer.

```.language-yaml
title: 2015 Year Books Photos
```

```
{{ title | first:4 }}
```

```.language-output
2015
```
