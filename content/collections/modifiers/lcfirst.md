---
id: 638e875e-2cc8-4b7b-953a-4f1a44c76e4d
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Lcfirst
---
Converts the first character of the supplied string to lower case.

```yaml
title: Wow
```

::tabs

::tab antlers
```antlers
{{ title | lcfirst }}
```
::tab blade
```blade
{{ Statamic::modify($title)->lcfirst() }}
```
::

```html
wow
```
