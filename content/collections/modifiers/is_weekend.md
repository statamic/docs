---
id: 22a4460a-b24a-4e24-bd8c-655d03e6d3de
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Weekend'
---
Returns `true` if date is on the weekend.

```yaml
date: December 25 2015
```

::tabs

::tab antlers
```antlers
{{ if date | is_weekend }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isWeekend()->fetch()) ... @endif
```
::


```html
false
```
