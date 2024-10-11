---
id: 054a230c-a655-48b0-af8b-a963bb0b89b0
blueprint: modifiers
modifier_types:
  - conditions
title: 'Is Blank'
---
Returns `true` if the string contains only whitespace chars.

```yaml
ghost:
zombie: BRAINSSSS
```

::tabs

::tab antlers
```antlers
{{ if ghost | is_blank }}
{{ if zombie | is_blank }}
```
::tab blade
```blade
@if (Statamic::modify($ghost)->isBlank()->fetch()) @endif
@if (Statamic::modify($zombie)->isBlank()->fetch()) @endif
```
::

```html
true
false
```
