---
id: 22a4460a-b24a-4e24-bd8c-655d03e6d3de
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Weekend'
---
Returns `true` if date is on the weekend.

```yaml
date: June 19 2012
```

::tabs

::tab antlers
```antlers
{{ if date | is_weekend }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isWeekend()->fetch()) ... @endif
```
::


```html
false
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
