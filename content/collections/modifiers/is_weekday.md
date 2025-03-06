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
date: December 25 2015
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
By default, when using a modifier on a date variable, it will be operating on the UTC date rather than the localized date.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
