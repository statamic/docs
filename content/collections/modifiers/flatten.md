---
id: e893345c-03f7-466b-a400-bbd2545bd780
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Flatten
---
Flattens a multi-dimensional array (a Grid or Replicator field for example) into a single dimension.

```yaml
ingredients:
  spices: [garlic, cumin, ginger, turmeric, paprika, curry powder]
  vegetables: [tomatoes, onion]
  meat: [chicken]
```

```
{{ ingredients | flatten }}
```

```yaml
ingredients:
  - garlic
  - cumin
  - ginger
  - turmeric
  - paprika
  - curry powder
  - tomatoes
  - onion
  - chicken
```
