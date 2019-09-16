---
types:
  - conditions
id: 054a230c-a655-48b0-af8b-a963bb0b89b0
---
Returns `true` if the string contains only whitespace chars.

```.language-yaml
ghost: 
zombie: BRAINSSSS
```

```
{{ if ghost | is_blank }}
{{ if zombie | is_blank }}
```

```.language-output
true
false
```