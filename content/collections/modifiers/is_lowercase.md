---
id: 97ff9a80-1e19-4f6d-b9e8-b5f4223e19d7
blueprint: modifiers
modifier_types:
  - string
  - conditions
title: 'Is Lowercase'
---
Returns `true` if string is only lowercase characters.

```yaml
topic: fhqwhgads
from: Sibbie
```

::tabs

::tab antlers
```antlers
{{ if topic | is_lowercase }}
{{ if from | is_lowercase }}
```
::tab blade
```blade
@if (Statamic::modify($topic)->isLowercase()->fetch()) ... @endif
@if (Statamic::modify($from)->isLowercase()->fetch()) ... @endif
```
::

```html
true
false
```
