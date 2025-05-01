---
id: eef6642f-053a-4720-a373-78b950d949f2
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Kebab Case
---
Converts a string into `kebab-case`.

```yaml
string: statamicIsAwesome
```

::tabs

::tab antlers
```antlers
{{ string | kebab }}
```
::tab blade
```blade
{{ Statamic::modify($string)->kebab() }}
```
::

```html
statamic-is-awesome
```
