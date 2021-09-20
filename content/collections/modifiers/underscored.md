---
id: 61a30026-8f98-454e-bcf2-fa7ec1435438
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Underscored
---
Returns a lowercase and trimmed string separated by underscores.
Underscores are inserted before uppercase characters (with the exception
of the first character of the string), and in place of spaces as well as dashes.


```.language-yaml
string: Please and thank you
```

```
{{ string | underscored }}
```

```.language-output
please_and_thank_you
```
