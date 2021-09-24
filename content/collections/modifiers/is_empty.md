---
id: a94a24ce-500d-4194-85db-85fcbb552e06
blueprint: modifiers
modifier_types:
  - array
title: 'Is Empty'
---
Checks to see if an array is empty without any set values. Works with numeric indexes, associative, and string keyed arrays of all depths. It's pretty smart, as these things go.

```yaml
some_data:
  - is living here
more_data:
  with:
  hopes:
  and:
  dreams:
    -
```

```
{{ if some_data | is_empty }}
{{ if more_data | is_empty }}

```

```html
false
true
```
