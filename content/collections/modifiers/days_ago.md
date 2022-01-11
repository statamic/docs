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
// Example previous date
date: December 8 2021
```

```
//Example current date on your server:
December 12 2021
```

```antlers
//Antlers Frontend
{{ date | days_ago }}
```

```html
//Output:
4
```
