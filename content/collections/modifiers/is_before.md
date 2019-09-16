---
types:
  - date
  - conditions
id: 85b0a5d9-eb77-4bc2-b60e-7b4d3f9aa406
---
Returns `true` if a date variable is before another date. That second date can be the name of another variable or a literal date string.

```.language-yaml
start_date: January 17 2015
end_date: December 1 2015
```

```
{{ if end_date | is_before:start_date }}
{{ if start_date | is_before:2014 }}
{{ if start_date | is_before:end_date }}
```

```.language-output
false
false
true
```


