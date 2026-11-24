---
id: 40578328-3288-4c54-a475-8afad19a37e6
blueprint: modifiers
modifier_types:
  - date
title: Relative
---
Returns a date difference in a nice, human readable, string format. This modifier will add a phrase after the difference value relative to the current date and the passed in date.

You can turn off the extra words "ago", "until", and so on by passing `true` as a parameter

The string will be localized into your current site locale.

```yaml
# Assuming the current date is June 19, 2014.
past_date: June 19 2012
future_date: June 19 2015
```

::tabs

::tab antlers
```antlers
{{ past_date | relative }}
{{ past_date | relative(true) }}
{{ future_date | relative }}
{{ future_date | relative(true) }}
```
::tab blade
```blade
{{ Statamic::modify($past_date)->relative() }}
{{ Statamic::modify($past_date)->relative(true) }}
{{ Statamic::modify($future_date)->relative() }}
{{ Statamic::modify($future_date)->relative(true) }}
```
::

```html
2 years ago
2 years
1 year from now
1 year
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
