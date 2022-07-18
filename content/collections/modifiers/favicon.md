---
id: 9c7ad945-2d02-423b-ae97-09cbe7ffed0d
blueprint: modifiers
modifier_types:
  - markup
attributes: true
title: Favicon
---
Given a valid URL will generate a proper favicon meta tag.

```yaml
icon: /assets/img/favicon.png
```

```
{{ icon | favicon }}
```

```html
<link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.png">
```
