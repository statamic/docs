---
id: 81ba1f6a-0eaf-441b-a26d-1aeb81f135a0
blueprint: modifiers
modifier_types:
  - string
  - utility
title: URL Encode Except Slashes
---
URL-encodes a string. Just like [urlencode](/modifiers/urldecode), but doesn't encode forward slashes (`/`).

```yaml
string: please and thank you/Mommy
```

::tabs

::tab antlers
```antlers
{{ string | urlencode_except_slashes }}
```
::tab blade
```blade
{!! Statamic::modify($string)->urlencode_except_slashes() !!}
```
::

```html
please+and+thank+you/Mommy
```
