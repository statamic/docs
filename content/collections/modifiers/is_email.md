---
types:
  - string
  - conditions
id: 471b3281-4573-43ee-9fee-eb55edf26ad0
---
Returns `true` if a string is a valid email address.

```.language-yaml
an_email: lknope@inpra.org
not_an_email: waffles
```

```
{{ if an_email | is_email }}
{{ if not_an_email | is_email }}
```

```.language-output
true
false
```


