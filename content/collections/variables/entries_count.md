---
id: b4cd82ee-8a96-4aba-a8fc-dfee171335de
blueprint: variables
types:
  - term
title: 'Entries Count'
description: Get the number of entries that use this taxonomy term.
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

On a [nestable taxonomy](/taxonomies#ordering-and-hierarchy) this counts the entries tagged with the term's descendants too, so it agrees with what `{{ entries }}` returns. There's no way to opt out — [query the entries yourself](/taxonomies#descendant-entries) with `with_descendants="false"` if you need a count of only the directly tagged ones.
