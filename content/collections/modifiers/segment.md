---
modifier_types:
  - string
  - utility
id: 87cb26b4-3eb1-4bd7-8d80-913f1ba21932
---
Returns a segment by number from any valid URL or URI.

```.language-yaml
example: /this/is/pretty/neat
```

```
{{ example | segment:4 }}
```

```.language-output
neat
```
