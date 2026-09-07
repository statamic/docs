---
id: cfbf8926-47ee-42e1-a972-86e3dc13633b
blueprint: modifiers
modifier_types:
  - conditions
  - date
  - number
title: 'Is Between'
---
Returns `true` if a date variable is between two other dates. Those dates can be the name of other variables or literal date strings.

```yaml
date: June 19 2012
start_date: June 1 2012
end_date: July 1 2012
```

::tabs

::tab antlers
```antlers
{{ if date | is_between($start_date, $end_date) }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isBetween([$start_date, $end_date])->fetch()) @endif
```
::

```html
true
```

:::warning
Date modifiers preserve the date value's timezone by default. Dated entries use UTC. Enable `localize_dates_in_modifiers` in `config/statamic/system.php` to convert dates to your display timezone before applying modifiers.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
