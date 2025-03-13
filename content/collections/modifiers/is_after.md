---
id: 3c167645-5ad1-45b4-b6df-22b0d2c95abf
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is After'
---
Returns `true` if a date variable is after another date. That second date can be the name of another variable or a literal date string.

```yaml
start_date: January 17 2015
end_date: December 1 2015
```

::tabs

::tab antlers
```antlers
{{ if end_date | is_after($start_date) }}
{{ if start_date | is_after(2014) }}
{{ if start_date | is_after($end_date) }}
```
::tab blade
```blade
@if (Statamic::modify($end_date)->isAfter($start_date)->fetch()) @endif
@if (Statamic::modify($start_date)->isAfter(2014)->fetch()) @endif
@if (Statamic::modify($start_date)->isAfter($end_date)->fetch()) @endif
```
::

```html
true
true
false
```
