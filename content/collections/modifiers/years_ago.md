---
modifier_types:
  - date
id: e73f1574-732e-4a74-be47-37e1fddb05d6
parse_content: true
---
Returns the number of years since a given date variable. Statamic will attempt to parse any string as a date, but try to keep it in the least ambiguous date format possible.

```.language-yaml
date: October 1 2015
```

{{ noparse }}
```
{{ date | years_ago }}
```
{{ /noparse }}

```.language-output
{{ test_date | years_ago }}
```
