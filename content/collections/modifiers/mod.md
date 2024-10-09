---
id: 10875a6a-9cb8-4e2a-9d39-0d8e4059d815
blueprint: modifiers
modifier_types:
  - math
title: Mod
---
Get the modulus value (remainder after division) of a value split by another numeric value. Pass an integer or the name of a second variable as the parameter. Also supports `%` as shorthand.

```yaml
bottles: 3
glasses: 14
```

::tabs

::tab antlers
```antlers
{{ glasses | mod(14) }}
{{ glasses | mod($bottles) }}
{{ glasses | %($bottles) }}

```
::tab blade
```blade
{{ Statamic::modify($glasses)->mod(14) }}
{{ Statamic::modify($glasses)->mod($bottles) }}
```
::

```html
0
2
2
```
