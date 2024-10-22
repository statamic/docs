---
id: d374ba18-d8cc-4700-a79c-c7da5a26b314
blueprint: variables
types:
  - content
title: Published
---
A boolean that specifies whether the content is published. Or "live", or "not a draft".

::tabs

::tab antlers
```antlers
{{ if published }}
    Published!
{{ else }}
    Draft
{{ /if }}
```
::tab blade
```blade
@if ($published)
  Published!
@else
  Draft
@endif
```
::