---
id: e08b1034-5d58-4fae-8f6a-8efd9a65d6d9
blueprint: modifiers
modifier_types:
  - conditions
title: 'Contains All'
---
Search a string against multiple needles and return `true` if all are found, otherwise `false`. Case-insensitive.

```yaml
summary: "It was the best of times, it was the worst of times."
```

```
{{ if summary | contains_all:best:worst }}
{{ if summary | contains_all:best:better }}
```

```html
true
false
```
