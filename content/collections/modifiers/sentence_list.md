---
id: eed4c5bc-0923-4f54-ad37-ca9a3384e1e0
blueprint: modifiers
modifier_types:
  - array
  - markup
title: 'Sentence List'
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

By default, the "glue" is the word "and", and will be translated appropriately. But, you can change it with the first argument:

```
I like {{ things | sentence_list:& }}.
```

```.language-output
I like batman, zombies, & scrunchies.
```

The second argument controls the oxford comma. Set that to 0 and it'll get removed:

```
I like {{ things | sentence_list:and:0 }}.
```

```.language-output
I like batman, zombies and scrunchies.
```
