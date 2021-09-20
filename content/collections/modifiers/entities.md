---
id: 50c06e32-9b94-4129-85ba-7cc4201b9e3f
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Entities
---
Encode a string with HTML entities via PHP's [htmlentities()][entities] function. This is the opposite of the [decode][decode] modifier.

```.language-yaml
string: "The 'bacon' is <b>crispy</b>";
```

```
{{ string | entities }}
```

```.language-output
The &#039;bacon&#039; is &lt;b&gt;crispy&lt;/b&gt;
```

[entities]: http://php.net/manual/en/function.htmlentities.php
[decode]: /modifiers/decode
