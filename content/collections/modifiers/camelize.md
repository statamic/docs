---
modifier_types:
  - string
id: fe6dbf39-7870-4aa4-9acb-23b4cbf4bf87
---
Returns a camelCase version of a string. Trims surrounding spaces, capitalizes letters following digits, spaces, dashes and underscores, and removes spaces, dashes and underscores. It's a programmer-type thing, great for converting between code styles.

```.language-yaml
method: make_everything_better
```

```
{{ method | camelize }}
```

```.language-output
makeEverythingBetter
```

