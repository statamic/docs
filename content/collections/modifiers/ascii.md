---
id: 807d2a16-dbaa-4aaf-887c-9682b63a6af8
blueprint: modifiers
modifier_types:
  - string
title: Ascii
---
Replaces all non-ASCII characters with their closest ASCII counterparts and removes any unsupported characters completely. This is very useful for converting foreign language strings into something more code-friendly.

```yaml
title: lemoñade
```

```
{{ title | ascii }}
```

```html
lemonade
```
