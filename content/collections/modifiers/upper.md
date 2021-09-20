---
id: 33b1003c-6ce8-47db-a4ec-bbc323e15820
blueprint: modifiers
modifier_types:
  - string
title: Upper
---
Transform a string into uppercase. Multi-byte friendly.

```.language-yaml
string: That is über neat.
```

```
{{ string | upper }}
```

```.language-output
THAT IS ÜBER NEAT.
```
