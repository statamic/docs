---
types:
  - string
  - utility
id: be5541eb-4e33-4699-8035-61ce09de3247
---
Returns a string with smart quotes, ellipsis characters, and dashes from Windows-1252 (commonly used in Word documents) replaced by their ASCII equivalents.

```.language-yaml
string: >
  “I see…”
```

```
{{ string | tidy }}
```

```.language-output
"I see..."
```
