---
id: a01e28a5-7c59-436c-8137-98e9481631ba
modifier_types:
  - array
title: 'Filter Empty'
---
Filters falsy values out of an array or collection, including `null`, `false`, `0`, `'0'`, empty strings, and empty arrays. Existing keys are preserved.

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
