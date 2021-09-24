---
id: ab02d964-9a39-4f2b-ae87-d5248af9101e
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Replace
---
Find and replace all occurrences of a string with a totally different string.

```yaml
description: This cat video is the okayest thing ever.
```

```
{{ description replace="cat|dog" }}
```

```html
This dog video is the okayest thing ever.
```
