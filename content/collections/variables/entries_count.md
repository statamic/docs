---
id: b4cd82ee-8a96-4aba-a8fc-dfee171335de
blueprint: variables
types:
  - term
title: 'Entries Count'
---
Get the number of entries that use this taxonomy term.

::tabs

::tab antlers
```antlers
There are {{ entries_count }} 'news' entries.
```
::tab blade
```blade
There are {{ $entries_count }} 'news' entries.
```
::

```html
There are 85 'news' entries.
```
