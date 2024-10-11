---
id: 0438995d-7100-4a72-9c0c-985e00f482bb
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Leap Year'
---
Returns `true` if date is in a leap year. Try and find a regular use for this one, we dare you.

```yaml
date: November 2016
another_date: November 2017
```

::tabs

::tab antlers
```antlers
{{ if date | is_leap_year }}
{{ if another_date | is_leap_year }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isLeapYear()->fetch()) ... @endif
@if (Statamic::modify($another_date)->isLeapYear()->fetch()) ... @endif
```
::

```html
true
false
```
