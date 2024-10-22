---
id: e13ecc17-1458-42f5-a55c-f7fcbac743ad
blueprint: modifiers
modifier_types:
  - utility
title: 'To Tabs'
---
Converts all instances of a specified number of spaces in a string to tabs. `4` by default. This is a boring modifier to output examples of. Here's just a few examples on how the syntax looks.

::tabs

::tab antlers
```antlers
{{ string | to_tabs }}
{{ string | to_tabs(4) }}
```
::tab blade
```blade
{{ Statamic::modify($string)->toTabs() }}
{{ Statamic::modify($string)->toTabs(4) }}
```
::
