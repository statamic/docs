---
id: 756d23b4-209c-457c-b9f5-d69347bbe8fe
blueprint: modifiers
modifier_types:
  - date
  - string
title: Format
---
Given a date string, or anything that sort of looks like a date string, `format` will convert it to a [Carbon][carbon] instance and allow you to format it with PHP's [datetime format][datetime] variables.

```yaml
event_date: April 15 2016
```

```
{{ event_date format="Y-m-d"}}
```

```html
2016-04-15
```

[carbon]: http://carbon.nesbot.com
[datetime]: https://www.php.net/manual/en/datetime.format.php
