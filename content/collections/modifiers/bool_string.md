---
id: c3214196-3d0d-4a3d-b6c3-1ee4960cfedd
blueprint: modifiers
modifier_types:
  - utility
title: 'Bool String'
---
Converts a truthy value to the string `true` and a falsy to the string `false`. Check out [https://www.php.net/manual/en/language.types.boolean.php](https://www.php.net/manual/en/language.types.boolean.php) to see what PHP considers truthy and falsy.

```yaml
no: 0
yes: "hell, yea"
sure: -1
```

::tabs

::tab antlers
```antlers
{{ no | bool_string }}
{{ yes | bool_string }}
{{ sure | bool_string }}
```
::tab blade
```blade
{{ Statamic::modify($no)->boolString() }}
{{ Statamic::modify($yes)->boolString() }}
{{ Statamic::modify($sure)->boolString() }}
```
::

```html
false
true
true
```
