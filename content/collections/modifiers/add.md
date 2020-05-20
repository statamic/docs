---
modifier_types:
  - math
id: 53debd55-5d53-4254-ad86-49a26cb09594
---
Add a value or another variable to your variable. Pass an integer or the name of a second variable as the parameter. Also supports `+` as shorthand.

```.language-yaml
books: 5
magazines: 10
```

```
{{ books | add:5 }}
{{ books | add:magazines }}
{{ books | +:magazines }}
```

```.language-output
10
15
15
```
