---
types:
  - string
  - utility
id: 6854539a-4661-483b-bb1f-2d28df0db76e
---
Ensures that the string ends with a specified string. If it doesn't, it will now.

```.language-yaml
links:
  - statamic
  - wilderborn.com
```

```
{{ links }}
  <li>{{ value ensure_right=".com" }}</li>
{{ /links }}
```

```.language-output
<li>statamic.com</li>
<li>wilderborn.com</li>
```