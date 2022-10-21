---
id: 6866c25b-1266-4908-8325-dce4e5146f5b
blueprint: modifiers
modifier_types:
  - array
  - utility
title: 'Option List'
related_entries:
  - d8a8568c-bb93-4e84-8d30-e527b3b02876
  - eed4c5bc-0923-4f54-ad37-ca9a3384e1e0
  - cbab1bb5-302e-499d-badb-f154dbae751d
  - 9dfc5020-3d14-4774-a1f6-d82d051cb964
---
Turn an array into a pipe-delimited string. Useful when passing an array of things into a parameter.

```yaml
collections:
  - blog
  - news
  - wigs
```

```
{{ collection from="{collections|option_list}" }}
```

Can also be used by its alias, [`piped`](/modifiers/piped).