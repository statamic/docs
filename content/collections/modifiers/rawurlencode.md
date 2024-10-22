---
id: a4bf0c06-9210-4200-881b-feb9011ea2f7
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Raw URL Encode
---
URL-encode a variable according to [RFC 3986][rfc-3986].
```yaml
example: please and thank you/Mommy
```

::tabs

::tab antlers
```antlers
http://example.com/{{ example | rawurlencode }}
```
::tab blade
```blade
https://example.com/{{ Statamic::modify($example)->rawurlencode() }}
```
::

```html
http://example.com/please%20and%thank&20you%2FMommy
```

[rfc-3986]: http://php.net/manual/en/function.rawurlencode.php
