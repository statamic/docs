---
id: 054a230c-a655-48b0-af8b-a963bb0b89b0
blueprint: modifiers
modifier_types:
  - conditions
title: 'Is Blank'
---
Returns `true` if the string contains only whitespace chars.

```yaml
ghost:
zombie: BRAINSSSS
```

```
{{ if ghost | is_blank }}
{{ if zombie | is_blank }}
```

```html
true
false
```
