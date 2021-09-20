---
id: 4444ed5b-b543-424b-b7cf-a1eeff0213f9
blueprint: modifiers
modifier_types:
  - markup
  - string
  - utility
title: Last
---
Returns the last X characters of a string, where X is any positive integer.

```.language-yaml
title: 2015 Denver Nuggets
```

```
{{ title | last:7 }}
```

```.language-output
Nuggets
```
