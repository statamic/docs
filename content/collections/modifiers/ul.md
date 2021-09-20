---
id: 85910466-876b-4fc7-9dd1-c9baa7f7870a
blueprint: modifiers
modifier_types:
  - array
  - markup
title: UL
---
Turn an array into an HTML unordered list element.

```.language-yaml
food:
  - sushi
  - broccoli
  - kale
```

```
{{ food | ul }}
```

```.language-output
<ul>
  <li>sushi</li>
  <li>broccoli</li>
  <li>kale</li>
</ul>
```
