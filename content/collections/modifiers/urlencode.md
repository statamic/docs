---
id: b27e8b53-f9bd-471d-8f36-17d51ec11a32
blueprint: modifiers
modifier_types:
  - string
  - utility
title: URL Encode
---
URL-encodes a string. The inverse of [urldecode](/modifiers/urldecode).

```yaml
string: I just want & need $pecial characters!
```

::tabs

::tab antlers
```antlers
{{ string | urlencode }}
```
::tab blade
```blade
{!! Statamic::modify($string)->urlencode() !!}
```
::

```html
I+just+want+%26+need+%24pecial+characters%21
```

If you don't want forward slashes (`/`) to be encoded, use the [urlencode_except_slashes](/modifiers/urlencode_except_slashes) modifier instead.