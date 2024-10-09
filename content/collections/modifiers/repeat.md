---
id: 828a52f2-469e-4a20-82c1-15fd4d0e568c
blueprint: modifiers
modifier_types:
  - utility
title: Repeat
---
Repeats a value any given number of times. For fun.

```yaml
lyric: can't touch this
```

::tabs

::tab antlers
```antlers
{{ lyric | repeat(3) }}
```
::tab blade
```blade
{{ Statamic::modify($lyric)->repeat(3) }}
```
::

```html
can't touch this can't touch this can't touch this
```
