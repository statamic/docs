---
id: bd468407-617a-4cb8-93d8-cfd7148ec157
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Yesterday'
---
Returns `true` if a given date is yesterday, using the server's time.

```yaml
date: January 1, 2000
```

::tabs

::tab antlers
```antlers
{{ if date | is_yesterday }}
```
::tab blade
```blade
@if (Statamic::modify($date)->isYesterday()->fetch()) ... @endif
```
::

```html
false
```
