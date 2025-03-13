---
id: a9b3b597-9075-4320-bb6d-721f78c2de78
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Word Count'
---
Returns the number of words in a given string.

```yaml
string: There are probably seven words in this sentence.
```

::tabs

::tab antlers
```antlers
{{ string | word_count }}
```
::tab blade
```blade
{{ Statamic::modify($string)->wordCount() }}
```
::

```html
8
```
