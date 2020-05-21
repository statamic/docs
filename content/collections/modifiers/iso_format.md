---
modifier_types:
  - date
  - string
id: f72ffc08-4294-4c1c-9085-2794ee57962d
---
Given a date string, or anything that even sorta kinda looks like a date string, will convert it to a [Carbon][carbon] instance and allow you to format it with ISO format. This allows you to use inner translations rather than language packages you need to install on every machine where you deploy your site.

This is also compatible with [momentjs format method](https://momentjs.com/), it means you can use same format strings as you may have used in moment from your front-end or other node.js application.

Check out the [complete list of available replacements](https://carbon.nesbot.com/docs/#iso-format-available-replacements).

```.language-yaml
event_date: June 19 2020
```

```
{{ event_date iso_format="MMMM Do YYYY, h:mm:ss a"}}
```

```.language-output
June 15th 2018, 5:34:15 pm
```

[carbon]: http://carbon.nesbot.com
