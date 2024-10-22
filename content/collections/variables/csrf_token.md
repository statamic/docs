---
id: 1ff95c0b-e62a-46c2-87e7-75d84b10eaf1
blueprint: variables
types:
  - system
title: 'CSRF Token'
---
Output the CSRF token from the session.

::tabs

::tab antlers
```antlers
{{ csrf_token }}
```
::tab blade
```blade
{{ $csrf_token }}

-- or --

{{ csrf_token() }}
```
::
