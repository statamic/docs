---
types:
  - date
id: 7ba53a64-0266-4752-af5b-282a40dd11fa
parse_content: true
---
Returns the number of months since a given date variable. Statamic will attempt to parse any string as a date, but try to keep it in the least ambiguous date format possible.

```.language-yaml
date: October 1 2017
```

{{ noparse }}
```
{{ date | months_ago }}
```
{{ /noparse }}

```.language-output
{{ test_date | months_ago }}
```
