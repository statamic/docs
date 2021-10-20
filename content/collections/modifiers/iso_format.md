---
id: f72ffc08-4294-4c1c-9085-2794ee57962d
blueprint: modifiers
modifier_types:
  - date
  - string
title: 'Iso Format'
---
Given a date string, or anything that even sorta kinda looks like a date string, will convert it to a [Carbon][carbon] instance and allow you to format it with ISO format. This allows you to use inner translations rather than language packages you need to install on every machine where you deploy your site.

The language that will be used for translations depends on what you configured in your `config/statamic/sites.php` file. The `locale` and `fallback_locale` settings from the `config/app.php` file have **no influence** on this modifier.

This is also compatible with [momentjs format method](https://momentjs.com/), it means you can use same format strings as you may have used in moment from your front-end or other node.js application.

Check out the [complete list of available replacements](https://carbon.nesbot.com/docs/#iso-format-available-replacements).

```yaml
event_date: June 19 2020
```

```
{{ event_date iso_format="MMMM Do YYYY, h:mm:ss a"}}
```

```html
June 15th 2018, 5:34:15 pm
```

[carbon]: http://carbon.nesbot.com
