---
id: 84c6f375-10ca-4296-89a8-a22b9652b5d5
blueprint: modifiers
modifier_types:
  - string
title: 'Count Substring'
---
Returns the number of occurrences of search term in a given string. By default,
the comparison is case-insensitive, but can be made sensitive by setting the second parameter to `true`.

```yaml
quote: |
  Dude! You got a tattoo!
  So do you, dude! Dude, what does my tattoo say?
  Sweet! What about mine?
  Dude! What does mine say?
  Sweet! What about mine?
  Dude! What does mine say?
```

::tabs

::tab antlers
```antlers
{{ quote | count_substring('dude') }}
```
::tab blade
```blade
{{ Statamic::modify($quote)->countSubstring('dude') }}
```
::

```html
5
```


