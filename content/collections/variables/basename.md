---
id: 4aeaaa17-b92f-4be0-9f46-9e31c2589b8c
blueprint: variables
types:
  - asset
title: Basename
---
The basename of the asset, which is the filename _with_ the extension.

::tabs

::tab antlers
```antlers
{{ basename }}
```
::tab blade
```blade
{{ $basename }}
```
::

```html
black-bear-cubs.jpg
```
