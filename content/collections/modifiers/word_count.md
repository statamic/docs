---
id: a9b3b597-9075-4320-bb6d-721f78c2de78
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Word Count'
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
