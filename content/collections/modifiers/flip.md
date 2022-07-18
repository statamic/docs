---
id: f874e969-d579-4501-9140-e4005945d302
blueprint: modifiers
modifier_types:
  - array
title: Flip
---
Swaps the keys with their corresponding values. The old switcharoo.

```yaml
favorites:
  food: burger
  drink: soda
```

```
{{ favorites | json }}
{{ favorites | flip | json }}
```

```json
{"food":"burger","drink":"soda"}
{"burger":"food","soda":"drink"}
```
