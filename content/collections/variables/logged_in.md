---
id: 67c2b180-8568-4f92-9571-425898f293d5
blueprint: variables
types:
  - system
title: 'Logged In'
description: A boolean indicating whether the visitor is logged in.
---
Whether the visitor is logged in.

::tabs

::tab antlers
```antlers
{{ if logged_in }} Welcome back! {{ /if }}
```
::tab blade
```blade
@if ($logged_in) Welcome back! @endif
```
::
