---
id: a314e7fc-ad72-4afb-88b8-1ca4a0100c17
blueprint: modifiers
modifier_types:
  - conditions
  - utility
title: 'Is Json'
---
Returns `true` if string is valid json

```yaml
data: '{"book": "All The Places You'll Go"}'
```

::tabs

::tab antlers
```antlers
{{ if data | is_json }}
```
::tab blade
```blade
@if (Statamic::modify($data)->isJson()->fetch()) ... @endif
```
::

```html
true
```
