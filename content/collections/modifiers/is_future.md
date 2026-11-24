---
id: 26bf98af-5bc1-4ec9-b533-815872606e3b
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Future'
---
Returns `true` if date is in the future.

```yaml
# Assuming the current date is June 20, 2012.
date: June 19 2012
another_date: June 21 2012
```

::tabs

::tab antlers
```antlers
{{ if date | is_future }}
{{ if another_date | is_future }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isFuture()->fetch()) ... @endif
@if (Statamic::modify($another_date)->isFuture()->fetch()) ... @endif
```
::

```html
false
true
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
