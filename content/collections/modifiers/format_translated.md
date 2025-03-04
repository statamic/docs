---
id: 8cbea367-799f-4fb6-866e-519d571f7b3e
blueprint: modifiers
modifier_types:
  - date
  - string
title: 'Format Translated'
---
Given a date string, or anything that sort of looks like a date string, `format_translated` will convert it to a [Carbon][carbon] instance and allow you to format it using your site's configured locale.

```yaml
event_date: 2024-02-28
```

::tabs

::tab antlers
```antlers
{{ event_date | format_translated('l j F Y') }}
```
::tab blade
```blade
{{ Statamic::modify($event_date)->format_translated('l j F Y') }}
```
::

Assuming your site's locale is `fr_FR`:

```html
mercredi 28 février 2024
```

## Timezones

By default, when using a modifier on a date variable, the modifier will be operating on the UTC date, rather than the "localized" date.

Please refer to our [Timezones](/tips/timezones) guide for more information on using modifiers on dates.

[carbon]: http://carbon.nesbot.com