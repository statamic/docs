---
id: 0438995d-7100-4a72-9c0c-985e00f482bb
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Leap Year'
---
Returns `true` if date is in a leap year. Try and find a regular use for this one, we dare you.

```yaml
date: June 19 2012
another_date: June 19 2013
```

::tabs

::tab antlers
```antlers
{{ if date | is_leap_year }}
{{ if another_date | is_leap_year }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isLeapYear()->fetch()) ... @endif
@if (Statamic::modify($another_date)->isLeapYear()->fetch()) ... @endif
```
::

```html
true
false
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
