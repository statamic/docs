---
id: d5635238-7d7a-4543-9afc-912bee6ad6fd
blueprint: modifiers
modifier_types:
  - string
  - conditions
title: 'Is Uppercase'
---
Returns `true` if string is only uppercase characters.

```yaml
declaration: NOISES
cite: anonymous
```

::tabs

::tab antlers
```antlers
{{ if declaration | is_uppercase }}
{{ if cite | is_uppercase }}
```
::tab blade
```blade
@if (Statamic::modify($declaration)->isUppercase()->fetch()) ... @endif
@if (Statamic::modify($cite)->isUppercase()->fetch()) ... @endif
```
::

```html
true
false
```
