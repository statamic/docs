---
types:
  - condition
id: b2936dd3-f8b1-44a7-bb40-f3b0a8b47e90
---
Returns `true` if the string contains an uppercase character, `false` otherwise.

```.language-yaml
loud_noises: "I DON'T KNOW WHAT WE'RE YELLING ABOUT!"
```

```
{{ if loud_noises | has_upper_case }}
```

```.language-output
true
```