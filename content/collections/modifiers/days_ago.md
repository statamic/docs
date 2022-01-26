---
id: 811c1cf5-797f-4e77-af92-fde6c03e96d2
blueprint: modifiers
modifier_types:
  - date
parse_content: true
title: 'Days Ago'
---
Returns the number of days since a given date variable. Statamic will attempt to parse any string as a date, but try to keep it in the least ambiguous date format possible.


```yaml
# Let's assume a server date of "December 31 2021"
date: December 25 2021
```

```antlers
{{ date | days_ago }}
```

```output
6
```
