---
id: 06027289-825e-4205-bd3a-f375e26ab81e
blueprint: modifiers
modifier_types:
  - date
parse_content: true
date: 'October 1 2015 8:30:am'
title: 'Minutes Ago'
---
Returns the number of minutes since a given date variable. Statamic will attempt to parse any string as a date, but try to keep it in the least ambiguous date format possible.

```yaml
date: October 1 2015 8:30:am
```

{{ noparse }}
```
{{ date | minutes_ago }}
```
{{ /noparse }}

```html
{{ test_date | minutes_ago }}
```
