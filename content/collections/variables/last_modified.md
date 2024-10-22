---
id: 026f77b4-ab22-4c5f-b3be-ebc452e25c5b
blueprint: variables
types:
  - content
title: 'Last Modified'
---
The last modified time for the content file, or the asset.

Note that this is the timestamp for the file itself, not for when the content was published or updated. For example,
if you were to use git to deploy this file and it gets written on a server, the last modified time will be different.

::tabs

::tab
```antlers
{{ last_modified }}
```
::tab blade
```blade
{{ $page->last_modified }}
```
::