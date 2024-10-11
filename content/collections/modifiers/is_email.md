---
id: 471b3281-4573-43ee-9fee-eb55edf26ad0
blueprint: modifiers
modifier_types:
  - string
  - conditions
title: 'Is Email'
---
Returns `true` if a string is a valid email address.

```yaml
an_email: lknope@inpra.org
not_an_email: waffles
```

::tabs

::tab antlers
```antlers
{{ if an_email | is_email }}
{{ if not_an_email | is_email }}
```
::tab blade
```blade
@if (Statamic::modify($an_email)->isEmail()->fetch()) @endif
@if (Statamic::modify($not_an_email)->isEmail()->fetch()) @endif
```
::

```html
true
false
```


