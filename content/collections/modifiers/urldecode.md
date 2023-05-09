---
id: bf5018c9-3c15-4f93-927d-0ad3f728ac50
blueprint: modifiers
modifier_types:
  - string
  - utility
title: URL Decode
---
URL-decodes a string. The inverse of [urlencode](/modifiers/urlencode)

```yaml
string: I+just+want+%26+need+%24pecial+characters%21
```

```
{{ string | urldecode }}
```

```html
I just want & need $pecial characters!
```
