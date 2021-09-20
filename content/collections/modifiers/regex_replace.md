---
id: 711d7eb2-8748-42a8-90c6-c91efb3ed818
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Regex Replace'
---
Run a find and replace regex on a string of content.

```.language-yaml
description: This cat video is the best thing ever.
```

```
{{ description regex_replace="best|okayest" }}
```

```.language-output
This cat video is the okayest thing ever.
```
