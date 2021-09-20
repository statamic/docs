---
id: 6866c25b-1266-4908-8325-dce4e5146f5b
blueprint: modifiers
modifier_types:
  - array
  - utility
title: 'Option List'
---
Turn an array into a pipe-delimited string. Useful when passing an array of things into a parameter.

```.language-yaml
collections:
  - blog
  - news
  - wigs
```

```
{{ collection from="{collections|option_list}" }}
```

Can also be used by its alias, [`piped`](/modifiers/piped).
