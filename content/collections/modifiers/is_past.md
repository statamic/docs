---
id: fbf6eab4-0769-4e13-9205-f9f64fd44572
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Past'
---
Returns `true` if date is in the past.

```yaml
# Assuming the current date is June 20, 2012.
date: June 19 2012
another_date: June 21 2012
```

::tabs

::tab antlers
```antlers
{{ if date | is_past }}
{{ if another_date | is_past }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isPast()->fetch()) ... @endif
@if (Statamic::modify($another_date)->isPast()->fetch()) ... @endif
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
