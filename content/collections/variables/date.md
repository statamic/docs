---
id: 01b2a925-3f4e-473c-a983-ff8c29c8078f
blueprint: variables
types:
  - entry
title: Date
---
Get the date of the entry. This will be a `Carbon` instance.

However if you use it in your template as-is, it will get converted to a string using the format defined in your
system settings.

::tabs

::tab antlers
```antlers
{{ date }}
```
::tab blade
```blade
{{ $date }}
```
::

```html
February 16, 2016
```
