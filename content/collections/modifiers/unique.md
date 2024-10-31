---
id: f1486fa5-7cce-4c75-90cd-e131f5f6d184
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Unique
---
Returns all of the unique items in the array:

```yaml
checklist:
  - zebra
  - hippo
  - hyena
  - giraffe
  - zebra
  - hippo
  - hippo
  - hippo
  - hippo

```

::tabs

::tab antlers
```antlers
{{ checklist | unique | list }}
```
::tab blade
```blade
{{ Statamic::modify($checklist)->unique()->list() }}
```
::

```html
zebra, hippo, hyena, giraffe
```
