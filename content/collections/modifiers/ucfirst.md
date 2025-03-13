---
id: d977361d-0576-469d-9430-f4d82b5666b4
blueprint: modifiers
modifier_types:
  - string
title: Ucfirst
---
Converts the first character of a string to upper case.

```yaml
string: i wanna go home.
```

::tabs

::tab antlers
```antlers
{{ string | ucfirst }}
```
::tab blade
```blade
{{ Statamic::modify($string)->ucfirst() }}
```
::

```html
I wanna go home.
```
