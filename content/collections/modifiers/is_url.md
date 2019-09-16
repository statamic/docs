---
types:
  - string
  - conditions
id: 85303071-213b-4e6c-8fb7-10f703a4a52e
---
Returns `true` if a string is a valid URL.

```.language-yaml
a_url: http://google.com/
not_a_url: waffles
```

```
{{ if a_url | is_url }}
{{ if not_a_url | is_url }}
```

```.language-output
true
false
```


