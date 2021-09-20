---
id: 3c167645-5ad1-45b4-b6df-22b0d2c95abf
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is After'
---
Returns `true` if a date variable is after another date. That second date can be the name of another variable or a literal date string.

```.language-yaml
start_date: January 17 2015
end_date: December 1 2015
```

```
{{ if end_date | is_after:start_date }}
{{ if start_date | is_after:2014 }}
{{ if start_date | is_after:end_date }}
```

```.language-output
true
true
false
```
