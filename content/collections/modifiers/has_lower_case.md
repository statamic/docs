---
id: a5ce6691-840c-4bf7-b5f4-b87bb4845055
blueprint: modifiers
modifier_types:
  - conditions
title: 'Has Lower Case'
---
Returns `true` if the string contains a lowercase character, `false` otherwise.

```yaml
loud_noises: "I DON'T KNOW WHAT WE'RE YELLING ABOUT!"
```

::tabs
::tab antlers
```antlers
{{ if loud_noises | has_lower_case }}
```
::tab blade
```blade
@if (Statamic::modify($loud_noises)->hasLowerCase()->fetch())

@endif
```
::

```html
false
```