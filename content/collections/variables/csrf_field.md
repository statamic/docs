---
id: 344d0518-9deb-4bfc-ac62-fe48a9304a81
blueprint: variables
types:
  - system
title: 'CSRF Field'
---
A helper to output the CSRF token inside a hidden field named `_token` from the session.

POST requests in Statamic will be keeping an eye out for a `_token` value.

::tabs

::tab antlers
```antlers
{{ csrf_field }}
```
::tab blade
```blade
{!! $csrf_field !!}

-- or --
{!! csrf_field() !!}
```
::

```
<input type="hidden" name="_token" value="csrftokenhere" />
```
