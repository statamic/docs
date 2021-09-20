---
id: 14ef311c-b49a-45af-a0aa-e80f68793ba8
blueprint: modifiers
modifier_types:
  - string
  - utility
title: lower
---
Converts all characters in the string to lowercase.

```.language-yaml
yelling: I DON'T KNOW WHAT WE'RE YELLING ABOUT
```

```
{{ yelling | lower }}
```

```.language-output
i don't know what we're yelling about
```
