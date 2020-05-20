---
modifier_types:
  - string
id: bfc66a6c-e4f5-462b-822e-04c3402b5b8f
---
Trims a string and replaces consecutive whitespace characters with
a single space. This includes tabs and newline characters, as well as
multibyte whitespace such as the thin space and ideographic space.

```.language-yaml
title: Bad   at           typing
```

```
{{ title | collapse_whitespace }}
```

```.language-output
Bad at typing
```
