---
id: b27e8b53-f9bd-471d-8f36-17d51ec11a32
blueprint: modifiers
modifier_types:
  - string
  - utility
title: URL Encode
---
URL-encodes a string. The inverse of [urldecode](#urldecode)

```.language-yaml
string: I just want & need $pecial characters!
```

```
{{ string | urlencode }}
```

```.language-output
I+just+want+%26+need+%24pecial+characters%21
```
