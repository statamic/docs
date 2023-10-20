---
id: 48178377-da99-4754-ae9e-d294720cff33
blueprint: modifiers
modifier_types:
  - array
  - utility
title: Random
---
## Overview
Randomizes an array or collection.

## Example

Let's say you wanted to fetch a random item from an array. You could randomize the array and then apply a `limit: 1` and voila.

### The YAML
```yaml
arr:
  - Soda
  - Pop
  - Coke
```

### The Template
```
{{ arr | random | limit(1) }}
```

### The Output
```
Soda (maybe)
```
