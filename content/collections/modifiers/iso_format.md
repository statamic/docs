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

::tabs

::tab antlers
```antlers
{{ event_date | iso_format("MMMM Do YYYY, h:mm:ss a") }}
```
::tab blade
```blade
{{ Statamic::modify($event_date)->isoFormat(["MMMM Do YYYY, h:mm:ss a"]) }}
```
::

```html
June 15th 2018, 5:34:15 pm
```

You can use macro-formats to format and localize dates as well.

::tabs

::tab antlers
```antlers
{{ event_date | iso_format('ll') }}
```
::tab blade
```blade
{{ Statamic::modify($event_date)->isoFormat('ll') }}
```
::

Will output this on your English site:

```html
Jan 5, 2017
```

And this on your French site:

```html
5 janv. 2017
```

Check out the [complete list of available macro-formats](https://carbon.nesbot.com/docs/#available-macro-formats).

:::warning
By default, when using a modifier on a date variable, it will be operating on the UTC date rather than the localized date.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::

[carbon]: http://carbon.nesbot.com
