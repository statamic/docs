---
modifier_types:
  - array
  - markup
id: cbab1bb5-302e-499d-badb-f154dbae751d
---
Turn a simple array into a comma delimited string with a friendly little ampersand between the last two items.

```.language-yaml
fruits:
  - apples
  - bananas
  - jerky
```

```
{{ fruits | ampersand_list }}
```

```.language-output
apples, bananas & jerky
```
