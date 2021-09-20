---
id: e50e2b3a-4377-4a74-b25a-d1ecf5d2d04a
blueprint: modifiers
modifier_types:
  - string
title: Dashify
---
Returns a lowercase and trimmed string separated by dashes. Dashes are inserted before uppercase characters (with the exception of the first character of the string), and in place of spaces as well as underscores.

```.language-yaml
title: Just Because I Can
```

```
{{ title | dashify }}
```

```.language-output
just-because-i-can
```


