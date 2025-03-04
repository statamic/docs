---
id: 85b0a5d9-eb77-4bc2-b60e-7b4d3f9aa406
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Before'
---
Returns `true` if a date variable is before another date. That second date can be the name of another variable or a literal date string.

```yaml
start_date: January 17 2015
end_date: December 1 2015
```

::tabs

::tab antlers
```antlers
{{ if end_date | is_before($start_date) }}
{{ if start_date | is_before(2014) }}
{{ if start_date | is_before($end_date) }}
```
::tab blade
```blade
@if (Statamic::modify($end_date)->isBefore($start_date)->fetch()) @endif
@if (Statamic::modify($start_date)->isBefore(2014)->fetch()) @endif
@if (Statamic::modify($start_date)->isBefore($end_date)->fetch()) @endif
```
::

```html
false
false
true
```

## Timezones

By default, when using a modifier on a date variable, the modifier will be operating on the UTC date, rather than the "localized" date.

Please refer to our [Timezones](/tips/timezones) guide for more information on using modifiers on dates.