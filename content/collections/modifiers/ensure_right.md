---
id: 6854539a-4661-483b-bb1f-2d28df0db76e
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Ensure Right'
---
Ensures that the string ends with a specified string. If it doesn't, it will now.

```yaml
links:
  - statamic
  - wilderborn.com
```

```
{{ links }}
  <li>{{ value | ensure_right('.com') }}</li>
{{ /links }}
```

```html
<li>statamic.com</li>
<li>wilderborn.com</li>
```
