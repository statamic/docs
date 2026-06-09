---
id: aaf843db-96eb-4cfb-ba9c-45a86fcd2d34
blueprint: variables
types:
  - entry
title: Timestamp
description: Get the timestamp of the entry as an integer. Alias of `datestamp`.
---
Get the timestamp of the entry. This will be an integer.

Alias of `datestamp`.

::tabs

::tab antlers
```antlers
{{ timestamp }}
```
::tab blade
```blade
{{ $timestamp }}
```
::

```html
1425772800
```
