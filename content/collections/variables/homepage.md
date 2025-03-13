---
id: 80599fcb-69df-4de8-ad79-c918d9919e24
blueprint: variables
types:
  - system
title: Homepage
---
The URL of the homepage. Usually (but not always) the same as `{{ site:url }}`.

::tabs

::tab antlers
```antlers
{{ homepage }}
```
::tab blade
```blade
{{ $homepage }}
```
::

```html
https://docs.statamic.com/
```
