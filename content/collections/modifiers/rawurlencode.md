---
modifier_types:
  - string
  - utility
id: a4bf0c06-9210-4200-881b-feb9011ea2f7
---

URL-encode a variable according to [RFC 3986][rfc-3986].
```.language-yaml
example: please and thank you/Mommy
```

```
http://example.com/{{ example | rawurlencode }}
```

```.language-output
http://example.com/please%20and%thank&20you%2FMommy
```

[rfc-3986]: http://php.net/manual/en/function.rawurlencode.php
