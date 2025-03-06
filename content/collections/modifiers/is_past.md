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
date: October 21 2015
another_date: November 2019
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
By default, when using a modifier on a date variable, it will be operating on the UTC date rather than the localized date.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
