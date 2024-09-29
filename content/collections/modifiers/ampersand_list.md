---
id: cbab1bb5-302e-499d-badb-f154dbae751d
blueprint: modifiers
modifier_types:
  - array
  - markup
title: 'Ampersand List'
related_entries:
  - d8a8568c-bb93-4e84-8d30-e527b3b02876
  - 6866c25b-1266-4908-8325-dce4e5146f5b
  - eed4c5bc-0923-4f54-ad37-ca9a3384e1e0
  - 9dfc5020-3d14-4774-a1f6-d82d051cb964
---
Turn a simple array into a comma delimited string with a friendly little ampersand between the last two items.

```yaml
fruits:
  - apples
  - bananas
  - jerky
```

::tabs
```antlers
{{ fruits | ampersand_list }}
```

```blade
{{ Statamic::modify($fruits)->ampersandList() }}
```
::

```html
apples, bananas & jerky
```