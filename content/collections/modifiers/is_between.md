---
id: cfbf8926-47ee-42e1-a972-86e3dc13633b
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Between'
---
Returns `true` if a date variable is between two other dates. Those dates can be the name of other variables or literal date strings.

```.language-yaml
date: November 15 2015
start_date: July 4 2015
end_date: December 1 2015
```

```
{{ if date | is_between:start_date:end_date }}
```

```.language-output
true
```
