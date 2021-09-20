---
id: 6ebb6c28-d1f3-4362-92a0-8a16b5c9cd51
blueprint: modifiers
modifier_types:
  - date
parse_content: true
title: 'Hours Ago'
---
Returns the number of hours since a given date variable. Statamic will attempt to parse any string as a date, but try to keep it in the least ambiguous date format possible.

```.language-yaml
date: October 1 2015
```

{{ noparse }}
```
{{ date | hours_ago }}
```
{{ /noparse }}

```.language-output
{{ test_date | hours_ago }}
```
