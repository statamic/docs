---
modifier_types:
  - math
id: 10875a6a-9cb8-4e2a-9d39-0d8e4059d815
---
Get the modulus value (remainder after division) of a value split by another numeric value. Pass an integer or the name of a second variable as the parameter. Also supports `%` as shorthand.

```.language-yaml
bottles: 3
glasses: 14
```

```
{{ glasses | mod:14 }}
{{ glasses | mod:bottles }}
{{ glasses | %:bottles }}

```

```.language-output
0
2
2
```
