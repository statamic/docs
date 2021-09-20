---
id: a5ce6691-840c-4bf7-b5f4-b87bb4845055
blueprint: modifiers
modifier_types:
  - conditions
title: 'Has Lower Case'
---
Returns `true` if the string contains a lowercase character, `false` otherwise.

```.language-yaml
loud_noises: "I DON'T KNOW WHAT WE'RE YELLING ABOUT!"
```

```
{{ if loud_noises | has_lower_case }}
```

```.language-output
false
```
