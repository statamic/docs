---
id: 603701ba-5da7-4ec8-abe5-5bc9fe6861ea
blueprint: modifiers
modifier_types:
  - date
parse_content: true
title: 'Seconds Ago'
---
Returns the number of seconds since a given date variable. Statamic will attempt to parse any string as a date, but try to keep it in the least ambiguous date format possible.

```yaml
date: October 1 2015 8:30:am
```

{{ noparse }}
```
{{ date | seconds_ago }}
```
{{ /noparse }}

```html
{{ test_date | seconds_ago }}
```
