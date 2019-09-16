---
types:
  - markup
attributes: true
id: 9c7ad945-2d02-423b-ae97-09cbe7ffed0d
---
Given a valid URL will generate a proper favicon meta tag.

```.language-yaml
icon: /assets/img/favicon.png
```

```
{{ icon | favicon }}
```

```.language-output
<link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.png" />
```