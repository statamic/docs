---
types:
  - string
  - utility
id: bf5018c9-3c15-4f93-927d-0ad3f728ac50
---
URL-decodes a string. The inverse of [urlencode](#urlencode)

```.language-yaml
string: I+just+want+%26+need+%24pecial+characters%21
```

```
{{ string | urldecode }}
```

```.language-output
I just want & need $pecial characters!
```
