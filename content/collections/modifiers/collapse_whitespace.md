---
id: bfc66a6c-e4f5-462b-822e-04c3402b5b8f
blueprint: modifiers
modifier_types:
  - string
title: 'Collapse Whitespace'
---
Trims a string and replaces consecutive whitespace characters with
a single space. This includes tabs and newline characters, as well as
multibyte whitespace such as the thin space and ideographic space.

```yaml
title: Bad   at           typing
```

::tabs

::tab antlers
```antlers
{{ title | collapse_whitespace }}
```
::tab blade
```blade
{{ Statamic::modify($title)->collapseWhitespace() }}
```
::

```html
Bad at typing
```
