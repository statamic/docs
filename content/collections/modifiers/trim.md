---
types:
  - string
id: 64e41d8f-fedb-4639-bb09-d4e4cbfe3555
---
Returns a string with whitespace removed from the start and end of the string. Supports the removal of unicode whitespace.

```.language-yaml
string: "    This is so sloppy   "
```

```
{{ string | trim }}
```

```.language-output
This is so sloppy
```
