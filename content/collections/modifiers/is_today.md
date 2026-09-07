---
id: 50aa52bf-8c6c-4ec3-9af7-e610f65f8202
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Today'
---
Returns `true` if a given date is today, using the date value's timezone.

```yaml
# Assuming the current date is June 19, 2012.
date: June 19 2012
```

::tabs

::tab antlers
```antlers
{{ if date | is_today }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isToday()->fetch()) ... @endif
```
::

```html
true
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
