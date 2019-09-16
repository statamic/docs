---
types:
  - condition
id: 40fc5b1e-d0e7-488a-bf6e-e6ef4a8b7dd8
---
Returns `true` if the value ends with a given string. This comparison is case-insensitive.

```.language-yaml
punchline: That's what she said!
```

```
{{ if (punchline | ends_with:she said!) }}
{{ if (punchline | ends_with:your mom!) }}
```

```.language-output
true
false
```
