---
types:
  - date
  - string
id: 1d181ecf-69ad-4dbe-ae78-bb3b21547a8d
---
Given a date string, or anything that sort of looks like a date string, `format` will convert it to a [Carbon][carbon] instance and allow you to format it with PHP's [strftime format][strftime] variables. It will use the current locale defined in your system settings.

```.language-yaml
event_date: April 15 2016
```

```
{{ event_date format_localized="%A %d %B %Y" }}
```

Assuming your locale is `fr_FR`:

```.language-output
Vendredi 15 avril 2016
```


[carbon]: http://carbon.nesbot.com
[strftime]: http://php.net/strftime
