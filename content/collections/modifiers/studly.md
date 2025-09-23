---
id: 5a1d121e-0401-49e2-8460-842717d01047
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Studly Case
---
Converts a string into `StudlyCase`.

```yaml
string: statamic_is_awesome
```

::tabs

::tab antlers
```antlers
{{ string | studly }}
```
::tab blade
```blade
{{ Statamic::modify($string)->studly() }}
```
::

```html
StatamicIsAwesome
```
