---
id: 29863a25-6283-4338-baf5-82bd7c57541c
blueprint: modifiers
modifier_types:
  - math
  - utility
title: Ceil
---
Rounds a number up to the next whole number.

```yaml
number: 25.98
```

::tabs

::tab antlers
```antlers
{{ number | ceil }}
```
::tab blade
```blade
{{ Statamic::modify($number)->ceil() }}
```
::

```html
26
```
