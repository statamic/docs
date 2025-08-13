---
id: b3da88d2-7251-4827-aa88-e746647ee00b
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Raw URL Encode Except Slashes
---
URL-encode a variable according to [RFC 3986][rfc-3986]. Just like [rawurlencode](/modifiers/rawurlencode), but doesn't encode forward slashes (`/`).
```yaml
example: please and thank you/Mommy
```

::tabs

::tab antlers
```antlers
http://example.com/{{ example | rawurlencode_except_slashes }}
```
::tab blade
```blade
https://example.com/{{ Statamic::modify($example)->rawurlencode_except_slashes() }}
```
::

```html
http://example.com/please%20and%20thank%20you/Mommy
```

[rfc-3986]: http://php.net/manual/en/function.rawurlencode.php
