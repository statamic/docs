---
id: 18596c62-5535-41a8-91c4-b5769fb11085
blueprint: modifiers
modifier_types:
  - date
title: 'Modify Date'
---
Alters a timestamp by incrementing or decrementing in a format accepted by PHP's native [`strtotime()`](http://php.net/manual/en/function.strtotime.php) method.


```yaml
date: January 1, 2000
```

::tabs

::tab antlers
```antlers
{{ date | modify_date("-1 day") }}
{{ date | modify_date("next Sunday") }}
{{ date | modify_date("+3 months") }}
```
::tab blade
```blade
{{ Statamic::modify($date)->modifyDate('-1 day') }}
{{ Statamic::modify($date)->modifyDate('next Sunday') }}
{{ Statamic::modify($date)->modifyDate('+3 months') }}
```
::

```html
December 31, 1999
January 2, 2000
April 1, 2000
```

:::tip
As of Statamic 5, this modifier will return a copy of the Date. Earlier versions would **modify the variable directly** which will be passed onto any additional modifiers.
:::

## Timezones

By default, when using a modifier on a date variable, the modifier will be operating on the UTC date, rather than the "localized" date.

Please refer to our [Timezones](/tips/timezones) guide for more information on using modifiers on dates.