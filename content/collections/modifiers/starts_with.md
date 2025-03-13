---
id: 1b1581b6-859f-4559-850b-398b7437929a
blueprint: modifiers
modifier_types:
  - conditions
title: 'Starts With'
---
Returns `true` if the value starts with a given string. This comparison is case-insensitive.

```yaml
reply: Actually, I disagree because this is the internet.
```

::tabs

::tab antlers
```antlers
{{ if reply | starts_with('actually') }}
{{ if reply | starts_with('respectfully') }}
```
::tab blade
```blade
@if (Statamic::modify($reply)->startsWith('actually')->fetch())

@endif

@if (Statamic::modify($reply)->startsWith('respectfully')->fetch())

@endif
```
::

```html
true
false
```
