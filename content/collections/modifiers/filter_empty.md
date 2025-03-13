---
id: a01e28a5-7c59-436c-8137-98e9481631ba
modifier_types:
  - array
title: 'Filter Empty'
---
Filters out null values from an array.

```yaml
favorite_things:
  - pizza
  - null
  - ice cream
```

```antlers
{{ favorite_things | filter_empty }}
```

```output
pizza
ice cream
```
