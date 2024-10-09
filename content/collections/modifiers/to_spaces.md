---
id: d5ee1b1e-0ffa-45cd-b3aa-bfecb9a93325
blueprint: modifiers
modifier_types:
  - utility
title: 'To Spaces'
---
Converts all tabs in a string to a given number of spaces, `4` by default. This is a boring modifier to output examples of. Here's just a few examples on how the syntax looks.

::tabs

::tab antlers
```antlers
{{ string | to_spaces }}
{{ string | to_spaces(2) }}
```
::tab blade
```blade
{{ Statamic::modify($string)->toSpaces() }}
{{ Statamic::modify($string)->toSpaces(2) }}
```
::
