---
id: cbb290f3-ffd0-4dc1-8989-1d10a92ff17d
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Widont
---
Attempts to prevent widows (a line with a single word) in a string by adding non-breaking spaces between the last two words of each paragraph.

The first parameter allows you to customize the number of words to add non-breaking spaces to.

```.language-yaml
string: I Just Want Pretty Headlines and Sentences
```

```
{{ string | widont }}
{{ string | widont:4 }}
```

```.language-output
I Just Want Pretty Headlines and&nbsp;Sentences
I Just Want Pretty&nbsp;Headlines&nbsp;and&nbsp;Sentences
```
