---
id: 811c1cf5-797f-4e77-af92-fde6c03e96d2
blueprint: modifiers
modifier_types:
  - date
parse_content: true
title: 'Days Ago'
related_entries:
  - e73f1574-732e-4a74-be47-37e1fddb05d6
  - 603701ba-5da7-4ec8-abe5-5bc9fe6861ea
  - 06027289-825e-4205-bd3a-f375e26ab81e
  - 7ba53a64-0266-4752-af5b-282a40dd11fa
  - 6ebb6c28-d1f3-4362-92a0-8a16b5c9cd51
  - 6fcbfa5c-854e-4541-9955-505eca0d6bf7
  - 811c1cf5-797f-4e77-af92-fde6c03e96d2
  - 40578328-3288-4c54-a475-8afad19a37e6
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