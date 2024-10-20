---
id: c3d3e2c4-218e-4841-a594-647f10863866
blueprint: modifiers
modifier_types:
  - string
  - array
title: Explode
---
Breaks a string into an array of strings split on a given delimiter.

```yaml
places: Scotland, England, Switzerland, Italy
```

::tabs

::tab antlers
```antlers
{{ places | explode(',') | ul }}
```
::tab blade
```blade
{!! Statamic::modify($places)->explode(',')->ul() !!}
```
::

```html
<ul>
  <li>Scotland</li>
  <li>England</li>
  <li>Switzerland</li>
  <li>Italy</li>
</ul>
```
