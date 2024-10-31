---
id: d8a8568c-bb93-4e84-8d30-e527b3b02876
blueprint: modifiers
modifier_types:
  - array
  - markup
title: List
related_entries:
  - 6866c25b-1266-4908-8325-dce4e5146f5b
  - eed4c5bc-0923-4f54-ad37-ca9a3384e1e0
  - cbab1bb5-302e-499d-badb-f154dbae751d
  - 9dfc5020-3d14-4774-a1f6-d82d051cb964
---
Turn a simple array into a comma delimited list with no comma after the last item.

```yaml
things:
  - batman
  - zombies
  - scrunchies
```

::tabs

::tab antlers
```antlers
{{ things | list }}
```
::tab blade
```blade
{{ Statamic::modify($things)->list() }}
```
::

```html
batman, zombies, scrunchies
```