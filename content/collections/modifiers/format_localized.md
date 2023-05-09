---
id: 1d181ecf-69ad-4dbe-ae78-bb3b21547a8d
blueprint: modifiers
modifier_types:
  - date
  - string
title: 'Format Localized'
---
:::warning
Since Carbon 2.55.0 `formatLocalized` has been deprecated. Please use the [`iso_format`](/modifiers/iso_format) modifier instead.
:::

Given a date string, or anything that sort of looks like a date string, `format` will convert it to a [Carbon][carbon] instance and allow you to format it with PHP's [strftime format][strftime] variables. It will use the current locale defined in your system settings.

For this to work you will need to have the necessary locales installed in your hosting environment.

```yaml
event_date: April 15 2016
```

```
{{ event_date | format_localized('%A %d %B %Y') }}
```

Assuming your locale is `fr_FR`:

```html
Vendredi 15 avril 2016
```

[carbon]: http://carbon.nesbot.com
[strftime]: http://php.net/strftime
