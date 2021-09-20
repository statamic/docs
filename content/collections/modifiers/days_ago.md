---
id: 811c1cf5-797f-4e77-af92-fde6c03e96d2
blueprint: modifiers
modifier_types:
  - date
parse_content: true
title: 'Days Ago'
---
Returns the number of days since a given date variable. Statamic will attempt to parse any string as a date, but try to keep it in the least ambiguous date format possible.

```.language-yaml
date: October 1 2015
```

{{ noparse }}
```
{{ date | days_ago }}
```
{{ /noparse }}

```.language-output
{{ test_date | days_ago }}
```
