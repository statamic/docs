---
id: eed4c5bc-0923-4f54-ad37-ca9a3384e1e0
blueprint: modifiers
modifier_types:
  - array
  - markup
title: 'Sentence List'
related_entries:
  - d8a8568c-bb93-4e84-8d30-e527b3b02876
  - 6866c25b-1266-4908-8325-dce4e5146f5b
  - cbab1bb5-302e-499d-badb-f154dbae751d
  - 9dfc5020-3d14-4774-a1f6-d82d051cb964
---
Turn a simple array into a friendly comma delimited list with the word "and" before the last item.

```yaml
things:
  - batman
  - zombies
  - scrunchies
```

```
I like {{ things | sentence_list }}.
```

```html
I like batman, zombies, and scrunchies.
```

By default, the "glue" is the word "and", and will be translated appropriately. But, you can change it with the first argument:

```
I like {{ things | sentence_list:& }}.
```

```html
I like batman, zombies, & scrunchies.
```

The second argument controls the oxford comma. Set that to 0 and it'll get removed:

```
I like {{ things | sentence_list:and:0 }}.
```

```html
I like batman, zombies and scrunchies.
```