---
id: 4cb0f243-72f4-45a1-83d3-d72209907875
blueprint: modifiers
modifier_types:
  - string
  - conditions
title: 'Is External Url'
---
Returns `true` if a string is an external URL.

```yaml
google_url: http://google.com/
entry_url: /waffles
not_a_url: bacon
```

::tabs

::tab antlers
```antlers
{{ if google_url | is_external_url }}
{{ if entry_url | is_external_url }}
{{ if not_a_url | is_external_url }}
```
::tab blade
```blade
@if (Statamic::modify($google_url)->isExternalUrl()->fetch()) ... @endif
@if (Statamic::modify($entry_url)->isExternalUrl()->fetch()) ... @endif
@if (Statamic::modify($not_a_url)->isExternalUrl()->fetch()) ... @endif
```
::

```html
true
false
false
```