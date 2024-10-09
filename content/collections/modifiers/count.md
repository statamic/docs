---
id: a7b58312-3498-4807-b2bc-6fcb640fe231
blueprint: modifiers
modifier_types:
  - array
title: Count
---
Count the number of items in an array.

```yaml
fruit:
  - apples
  - bananas
  - bacon
```

::tabs

::tab antlers
```antlers
{{ fruit | count }}
```
::tab blade
```blade
{{ Statamic::modify($fruit)->count() }}
```
::

```html
3
```

