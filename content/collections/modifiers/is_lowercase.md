---
id: 97ff9a80-1e19-4f6d-b9e8-b5f4223e19d7
blueprint: modifiers
modifier_types:
  - string
  - conditions
title: 'Is Lowercase'
---
Returns `true` if string is only lowercase characters.

```yaml
topic: fhqwhgads
from: Sibbie
```

```
{{ if topic | is_lowercase }}
{{ if from | is_lowercase }}
```

```html
true
false
```
