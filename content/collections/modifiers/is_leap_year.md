---
types:
  - date
  - conditions
id: 0438995d-7100-4a72-9c0c-985e00f482bb
---
Returns `true` if date is in a leap year. Try and find a regular use for this one, we dare you.

```.language-yaml
date: November 2016 
another_date: November 2017
```

```
{{ if date | is_leap_year }}
{{ if another_date | is_leap_year }}
```

```.language-output
true
false
```