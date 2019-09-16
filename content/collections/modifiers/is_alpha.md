---
types:
  - string
  - conditions
id: a6aaac80-19b7-4400-af21-9147aff064c4
---
Returns `true` if string contains **only** alphabetic characters. Numbers, punctuation, whitespace, and another other special characters will cause a `false`.

```.language-yaml
secret_phrase: abcdefg
even_more_secret_phrase: abc123
```

```
{{ if secret_phrase | is_alpha }}
{{ if even_more_secret_phrase | is_alpha }}
```

```.language-output
true
false
```