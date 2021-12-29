---
id: 923f34bd-d17d-4353-821f-48e986bdce3b
blueprint: modifiers
modifier_types:
  - number
  - string
  - conditions
title: 'Is Alphanumeric'
---
Returns `true` if string contains **only** alphanumeric characters. Punctuation, whitespace, and another other special characters will cause a `false`.

```yaml
secret_phrase: abc123
even_more_secret_phrase: abc123!@#
```

```
{{ if secret_phrase | is_alphanumeric }}
{{ if even_more_secret_phrase | is_alphanumeric }}
```

```html
true
false
```
