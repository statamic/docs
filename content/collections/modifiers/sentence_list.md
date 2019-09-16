---
types:
  - array
  - markup
id: eed4c5bc-0923-4f54-ad37-ca9a3384e1e0
---
Turn a simple array into a friendly comma delimited list with the word "and" before the last item.

```.language-yaml
things:
  - batman
  - zombies
  - scrunchies
```

```
I like {{ things | sentence_list }}.
```

```.language-output
I like batman, zombies, and scrunchies.
```
