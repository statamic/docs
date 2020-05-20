---
modifier_types:
  - math
id: baad70cf-0af2-48bc-b102-b0da0293baf4
---
Subtract a value or another variable to your variable. Pass an integer or the name of a second variable as the parameter. Also supports `-` as shorthand.

```.language-yaml
capacity: 2500
reservations: 1900
```

```
{{ capacity | subtract:1900 }}
{{ capacity | subtract:reservations }}
{{ capacity | -:reservations }}
```

```.language-output
600
600
600
```
