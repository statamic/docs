---
types:
  - string
id: 33b1003c-6ce8-47db-a4ec-bbc323e15820
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
