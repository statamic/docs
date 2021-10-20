---
id: 171d9329-c456-45ca-a5e4-fc5bad7fb0ec
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Ensure Left'
---
Ensures that the string begins with a specified string. If it doesn't, it will now.

```yaml
links:
  - statamic.com
  - http://wilderborn.com
```

```
{{ links }}
  <li>{{ value ensure_left="http://" }}</li>
{{ /links }}
```

```html
<li>http://statamic.com</li>
<li>http://wilderborn.com</li>
```
