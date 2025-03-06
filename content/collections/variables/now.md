---
id: cbf3a055-9714-4f0f-a33b-508c59b4e1f8
blueprint: variables
types:
  - system
title: Now
---

The current date/time. If you use it on its own, it will be converted to your [`display_timezone`](/tips/timezones) and formatted using the default time format.

When you pass it to a tag parameter, or modifier, it will be treated as a UTC [`Carbon`](https://carbon.nesbot.com/) instance.

::tabs

::tab antlers
```antlers
{{ now }}
```
::tab blade
```blade
{{ $now }}

-- or --

{{ now() }}
```
::

```html
December 30th 2015
```

Also available as `{{ today }}` and `{{ current_date }}` aliases.
