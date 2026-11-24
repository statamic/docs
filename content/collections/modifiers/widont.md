---
id: cbb290f3-ffd0-4dc1-8989-1d10a92ff17d
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Widont
---
Attempts to prevent widows (a line with a single word) in a string by adding non-breaking spaces between the last two words of each paragraph.

The first parameter controls how many spaces are replaced at the end of each paragraph. It defaults to `1`, joining the final two words. A value of `4` joins the final five words.

```yaml
string: I Just Want Pretty Headlines and Sentences
```

::tabs

::tab antlers
```antlers
{{ string | widont }}
{{ string | widont(4) }}
```
::tab blade
```blade
{!! Statamic::modify($string)->widont() !!}
{!! Statamic::modify($string)->widont(4) !!}
```
::

```html
I Just Want Pretty Headlines and&nbsp;Sentences
I Just Want&nbsp;Pretty&nbsp;Headlines&nbsp;and&nbsp;Sentences
```
