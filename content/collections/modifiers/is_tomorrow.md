---
id: 2e700683-1fb1-4cde-a019-67770ceabadf
blueprint: modifiers
title: 'Is Tomorrow'
modifier_types:
  - date
  - conditions
---
Returns `true` if a given date is tomorrow, using the date value's timezone.

```yaml
# Assuming the current date is June 18, 2012.
date: June 19 2012
```

::tabs

::tab antlers
```antlers
{{ if date | is_tomorrow }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isTomorrow()->fetch()) ... @endif
```
::

```html
true
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
