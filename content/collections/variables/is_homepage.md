---
id: cc7c0df5-b3a6-4f67-8bd8-50d145ae756c
blueprint: variables
types:
  - system
title: Homepage
---
Whether you're on the homepage.

```
{{ if is_homepage }} Home sweet home {{ /if }}
```

If you're using [multiple sites](/multi-site), this will be true if you're on the homepage for any configured site.
