---
id: 50aa52bf-8c6c-4ec3-9af7-e610f65f8202
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Today'
---
Returns `true` if a given date is today, using the server's time.

```yaml
date: January 1, 2000
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
false
```

:::warning
By default, when using a modifier on a date variable, it will be operating on the UTC date rather than the localized date.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::
