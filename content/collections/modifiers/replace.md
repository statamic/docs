---
modifier_types:
  - string
  - utility
id: ab02d964-9a39-4f2b-ae87-d5248af9101e
---
Find and replace all occurrences of a string with a totally different string.

```.language-yaml
description: This cat video is the okayest thing ever.
```

```
{{ description replace="cat|dog" }}
```

```.language-output
This dog video is the okayest thing ever.
```
