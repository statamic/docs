---
id: 95e11355-75c3-49e9-ab0e-5b1856b3837a
blueprint: modifiers
modifier_types:
  - date
  - string
title: Format Time
---
Given a time string, `format_time` will format it using PHP's [datetime format][datetime] variables.

```yaml
start_time: 13:45
```

::tabs

::tab antlers
```antlers
{{ start_time | format_time }}
{{ start_time | format_time('g:ia') }}
{{ start_time | format_time('h:iA') }}
```
::tab blade
```blade
{{ Statamic::modify($start_time)->format_time() }}
{{ Statamic::modify($start_time)->format_time('g:ia') }}
{{ Statamic::modify($start_time)->format_time('h:iA') }}
```
::

```html
1:45pm
1:45pm
01:45PM
```

## Parameters

You can technically use any date formatting variables, but only the time-related really ones make sense here.

| Value | Description | Example |
| --------- | ----------- | -------------- |
| `a`  | Lowercase Ante meridiem and Post meridiem | `am` or `pm`  |
| `A`  | Uppercase Ante meridiem and Post meridiem | `AM` or `PM`  |
| `g`  | 12-hour format of an hour without leading zeros | `1` to `12`  |
| `G`  | 24-hour format of an hour without leading zeros | `0` to `23`  |
| `h`  | 12-hour format of an hour with leading zeros  | `01` to `12` |
| `H`  | 24-hour format of an hour with leading zeros  | `00` to `23` |
| `i`  | Minutes with leading zeros  | `00` to `59`  |
| `s`  | Seconds with leading zeros  | `00` to `59` |

[carbon]: http://carbon.nesbot.com
[datetime]: https://www.php.net/manual/en/datetime.format.php
