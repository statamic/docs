---
id: f72ffc08-4294-4c1c-9085-2794ee57962d
blueprint: modifiers
modifier_types:
  - date
  - string
title: 'Iso Format'
---
Given a date string, or anything that even sorta kinda looks like a date string, will convert it to a [Carbon][carbon] instance and allow you to format it with ISO format. This allows you to use inner translations rather than language packages you need to install on every machine where you deploy your site.

On the frontend, translations use the current site's language, configured in `resources/sites.yaml`.

This is also compatible with [momentjs format method](https://momentjs.com/), it means you can use same format strings as you may have used in moment from your front-end or other node.js application.

Check out the [complete list of available replacements](https://carbon.nesbot.com/guide/getting-started/localization.html#iso-format-available-replacements).

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
June 19th 2020, 12:00:00 am
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
Jun 19, 2020
```

And this on your French site:

```html
19 juin 2020
```

Check out the [complete list of available macro-formats](https://carbon.nesbot.com/guide/getting-started/localization.html#iso-format-available-replacements).

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::

[carbon]: http://carbon.nesbot.com
