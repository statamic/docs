---
id: a190fa95-c405-4e2c-b3c0-adfbe21f9bb2
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Weekday'
---
Returns `true` if date is a weekday.

```yaml
date: June 19 2012
```

::tabs

::tab antlers
```antlers
{{ if date | is_weekday }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isWeekday()->fetch()) ... @endif
```
::


```html
true
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
