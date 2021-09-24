---
id: 9002885e-20e9-4d1c-8396-1c8011076d2c
blueprint: modifiers
modifier_types:
  - array
  - string
  - utility
title: Length
---
Returns the number of items in an array or characters in a string.

```yaml
array:
  - Taylor Swift
  - Left Shark
  - Leroy Jenkins
string: LEEEEROOOYYYY JEEENKINNNSS!
```

```
{{ array | length }}
{{ string | length }}
```

```html
3
27
```
