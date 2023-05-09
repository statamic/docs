---
id: 4444ed5b-b543-424b-b7cf-a1eeff0213f9
blueprint: modifiers
modifier_types:
  - markup
  - string
  - utility
  - array
title: Last
---
Returns the last X characters of a string, where X is any positive integer, or the last item in an array.

```yaml
title: 2015 Denver Nuggets
array:
  - Sonic
  - Knuckles
  - Tails
```

```
{{ title | last(7) }}
{{ array | last }}
```

```html
Nuggets
Tails
```
