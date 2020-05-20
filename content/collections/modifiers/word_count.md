---
modifier_types:
  - string
  - utility
id: a9b3b597-9075-4320-bb6d-721f78c2de78
---
Returns the number of words in a given string.

```.language-yaml
string: There are probably seven words in this sentence.
```

```
{{ string | word_count }}
```

```.language-output
8
```
