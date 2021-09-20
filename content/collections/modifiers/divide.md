---
id: fedbc5fc-2478-4fba-92ba-4004bc6e8845
blueprint: modifiers
modifier_types:
  - math
title: Divide
---
Divide a value or another variable by your variable. Pass an integer or the name of a second variable as the parameter.

```.language-yaml
bacon: 21
skillets: 3
```

```
{{ bacon divide="skillets" }}
{{ skillets divide="3" }}
```

```.language-output
7
1
```
