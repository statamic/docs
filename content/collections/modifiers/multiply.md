---
modifier_types:
  - math
id: b1241017-a321-42ad-b550-a49ae8b3a805
---
Multiply a value or another variable to your variable. Pass an integer or the name of a second variable as the parameter. Also supports `*` as shorthand.

```.language-yaml
smiles: 3
winks: 4
```

```
{{ smiles | multiply:10 }}
{{ smiles | multiply:winks }}
{{ smiles | *:winks }}

```

```.language-output
30
12
12
```
