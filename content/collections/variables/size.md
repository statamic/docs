---
id: 514642f6-5e7b-4ffc-abad-7a2637615a45
blueprint: variables
types:
  - asset
title: Size
---
The file size of the asset, in an appropriate human-readable format.

::tabs

::tab antlers
```antlers
{{ assets:files }}
    {{ size }}
{{ /assets:files }}
```
::tab blade
```blade
<s:assets:files>
  {{ $size }}
</s:assets:files>
```
::

```html
11 B
127.69 KB
1.5 MB
2 GB
```
