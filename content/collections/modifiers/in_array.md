---
id: 4e349523-cba6-4f3b-a0e1-bd4e8b1cf6b9
blueprint: modifiers
modifier_types:
  - array
  - utility
  - conditions
title: 'In Array'
---
Check if an array contains a specific value. Returns `true` if a match is found.

Pass one value to look for in the array. In Antlers method syntax, leave variable names unquoted. Lists are searched by value using loose comparison; associative arrays are checked by key. To check for any of several values, use [overlaps](/modifiers/overlaps).

```yaml
shopping_list:
  - eggs
  - flour
  - beef jerky
want: eggs
```

::tabs

::tab antlers
```antlers
{{ if (shopping_list | in_array('flour')) }} GOT IT! {{ /if }}
{{ if (shopping_list | in_array(want)) }} GOT EM! {{ /if }}
{{ if (shopping_list | in_array('beef jerky')) }} YES I DID NOT FORGET! {{ /if }}
```
::tab blade
```blade
@if (Statamic::modify($shopping_list)->inArray('flour')->fetch()) GOT IT! @endif
@if (Statamic::modify($shopping_list)->inArray($want)->fetch()) GOT EM! @endif
@if (Statamic::modify($shopping_list)->inArray('beef jerky')->fetch()) YES I DID NOT FORGET! @endif
```
::


```html
GOT IT!
GOT EM!
YES I DID NOT FORGET!
```
