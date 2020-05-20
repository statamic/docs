---
modifier_types:
  - date
  - string
id: 756d23b4-209c-457c-b9f5-d69347bbe8fe
---
Given a date string, or anything that sort of looks like a date string, `format` will convert it to a [Carbon][carbon] instance and allow you to format it with PHP's [datetime format][datetime] variables.

```.language-yaml
event_date: April 15 2016
```

```
{{ event_date format="Y-m-d"}}
```

```.language-output
2016-04-15
```

[carbon]: http://carbon.nesbot.com
[datetime]: http://php.net/manual/en/function.date.php
