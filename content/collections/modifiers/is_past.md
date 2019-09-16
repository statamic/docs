---
types:
  - date
  - conditions
id: fbf6eab4-0769-4e13-9205-f9f64fd44572
---
Returns `true` if date is in the past.

```.language-yaml
date: October 21 2015
another_date: November 2019
```

```
{{ if date | is_past }}
{{ if another_date | is_past }}
```

```.language-output
true
false
```