---
id: bd468407-617a-4cb8-93d8-cfd7148ec157
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Yesterday'
---
Returns `true` if a given date is yesterday, using the date value's timezone.

```yaml
# Assuming the current date is June 20, 2012.
date: June 19 2012
```

::tabs

::tab antlers
```antlers
{{ if date | is_yesterday }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isYesterday()->fetch()) ... @endif
```
::

```html
true
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
