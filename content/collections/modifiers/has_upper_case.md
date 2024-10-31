---
id: b2936dd3-f8b1-44a7-bb40-f3b0a8b47e90
blueprint: modifiers
modifier_types:
  - conditions
title: 'Has Upper Case'
---
Returns `true` if the string contains an uppercase character, `false` otherwise.

```yaml
loud_noises: "I DON'T KNOW WHAT WE'RE YELLING ABOUT!"
```

::tabs

::tab antlers
```antlers
{{ if loud_noises | has_upper_case }}
```
::tab blade
```blade
@if (Statamic::modify($loud_noises)->hasUpperCase()->fetch())

@endif
```
::

```html
true
```
