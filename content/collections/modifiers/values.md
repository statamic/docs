---
id: b57caa5c-ae9e-4220-b8a6-f7c82d16f0df
blueprint: modifiers
title: Values
modifier_types:
  - array
  - utility
---
Retrieves just the keys from the given array.

```yaml
the_team:
    jack: Jack McDade
    jason: Jason Varga
    jesse: Jesse Leite
    joshua: Joshua Blum
    duncan: Duncan McClean
```

```
{{ the_team | values }}
```

```yaml
- Jack McDade
- Jason Varga
- Jesse Leite
- Joshua Blum
- Duncan McClean
```
