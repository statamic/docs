---
id: 3ef1e731-742e-48c2-81f0-6fa916ecda0a
blueprint: modifiers
modifier_types:
  - markup
  - string
  - utility
  - array
title: First
---
Returns the first X characters of a string, where X is any positive integer, or the first item in an array.

```yaml
title: 2015 Year Books Photos
array:
  - Sonic
  - Knuckles
  - Tails
```

```
{{ title | first(4) }}
{{ array | first }}
```

```html
2015
Sonic
```
