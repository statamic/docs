---
id: 6fcbfa5c-854e-4541-9955-505eca0d6bf7
blueprint: modifiers
modifier_types:
  - date
parse_content: true
title: 'Weeks Ago'
---
Returns the number of weeks since a given date variable. Statamic will attempt to parse any string as a date, but try to keep it in the least ambiguous date format possible.

```yaml
date: October 1 2015
```

{{ noparse }}
```
{{ date | weeks_ago }}
```
{{ /noparse }}

```html
{{ test_date | weeks_ago }}
```
