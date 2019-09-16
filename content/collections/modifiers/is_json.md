---
types:
  - conditions
  - utility
id: a314e7fc-ad72-4afb-88b8-1ca4a0100c17
---
Returns `true` if string is valid json

```.language-yaml
data: '{"book": "All The Places You'll Go"}'
```

```
{{ if data | is_json }}
```

```.language-output
true
```