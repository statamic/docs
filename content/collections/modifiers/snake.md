---
id: bc02aa00-6b1f-42f6-8cc3-737f803c5070
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Snake Case
---
Converts a string into `snake_case`.

```yaml
string: statamicIsAwesome
```

::tabs

::tab antlers
```antlers
{{ string | snake }}
```
::tab blade
```blade
{{ Statamic::modify($string)->snake() }}
```
::

```html
statamic_is_awesome
```
