---
id: 3c167645-5ad1-45b4-b6df-22b0d2c95abf
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is After'
---
Returns `true` if a date variable is after another date. That second date can be the name of another variable, a literal date string, or any relative date format (see [PHP DateTime](https://www.php.net/manual/en/datetime.formats.php#datetime.formats.relative) for more details).

```yaml
# Assuming the current date is June 22, 2012.
start_date: June 19 2012
end_date: June 21 2012
```

::tabs

::tab antlers
```antlers
{{ if end_date | is_after($start_date) }}
{{ if start_date | is_after("2012-06-18") }}
{{ if start_date | is_after("-1 day") }}
{{ if start_date | is_after($end_date) }}
```
::tab blade
```blade
@if (Statamic::modify($end_date)->isAfter($start_date)->fetch()) @endif
@if (Statamic::modify($start_date)->isAfter("2012-06-18")->fetch()) @endif
@if (Statamic::modify($start_date)->isAfter("-1 day")->fetch()) @endif
@if (Statamic::modify($start_date)->isAfter($end_date)->fetch()) @endif
```
::

```html
true
true
false
false
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
