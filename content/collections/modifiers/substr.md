---
modifier_types:
  - string
  - utility
id: 963d5e43-7bf5-4669-93af-d1990f7f3c97
---
Returns the string beginning at a given position with an optional length.
If length not specific, will return the rest of the string.

```.language-yaml
string: How neat is that?
```

```
{{ string | substr:0:3 }}
{{ string | substr:4:4 }}
{{ string | substr:-8:8 }}

```

```.language-output
How
neat
is that?
```
