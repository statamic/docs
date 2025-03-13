---
id: a6aaac80-19b7-4400-af21-9147aff064c4
blueprint: modifiers
modifier_types:
  - string
  - conditions
title: 'Is Alpha'
---
Returns `true` if string contains **only** alphabetic characters. Numbers, punctuation, whitespace, and another other special characters will cause a `false`.

```yaml
secret_phrase: abcdefg
even_more_secret_phrase: abc123
```

::tabs

::tab antlers
```antlers
{{ if secret_phrase | is_alpha }}
{{ if even_more_secret_phrase | is_alpha }}
```
::tab blade
```blade
@if (Statamic::modify($secret_phrase)->isAlpha()->fetch()) @endif
@if (Statamic::modify($even_more_secret_phrase)->isAlpha()->fetch()) @endif
```
::

```html
true
false
```
