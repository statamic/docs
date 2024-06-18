---
id: 9197be05-5e2d-400f-a0f0-c52a4d460e60
blueprint: modifiers
title: Keys
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
{{ the_team | keys }}
```

```yaml
- jack
- jason
- jesse
- joshua
- duncan
```
