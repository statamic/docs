---
id: 40fc5b1e-d0e7-488a-bf6e-e6ef4a8b7dd8
blueprint: modifiers
modifier_types:
  - conditions
title: 'Ends With'
---
Returns `true` if the value ends with a given string. This comparison is case-insensitive.

```yaml
punchline: That's what she said!
```

```
{{ if (punchline | ends_with:she said!) }}
{{ if (punchline | ends_with:your mom!) }}
```

```html
true
false
```
