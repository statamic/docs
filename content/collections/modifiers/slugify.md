---
modifier_types:
  - string
  - utility
id: 15ab735c-a877-423a-8e7f-c61e3f68744b
---
Converts the string into an URL slug. This includes replacing non-ASCII characters with their closest ASCII equivalents, removing remaining non-ASCII
and non-alphanumeric characters, and replacing whitespace with dashes. And then everything is lowercased.


```.language-yaml
string: Please, have some lemoñade.
```

```
{{ string | slugify }}
```

```.language-output
please-have-some-lemonade
```
