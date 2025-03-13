---
id: 5c1714c1-83fe-4690-8607-60d1f269408b
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Swap Case'
---
Returns a case swapped version of the string.

```yaml
string: IpHONE
```

::tabs

::tab antlers
```antlers
{{ string | swap_case }}
```
::tab blade
```blade
{{ Statamic::modify($string)->swapCase() }}
```
::

```html
iPhone
```
