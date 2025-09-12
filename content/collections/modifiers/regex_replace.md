---
id: 711d7eb2-8748-42a8-90c6-c91efb3ed818
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Regex Replace'
---
Run a find and replace regex on a string of content.

```yaml
link: https://www.catvideo.com
```

::tabs

::tab antlers
```antlers
{{ link | regex_replace('https?://(www.)?([^/]+)/?.*', '\2') }}
```
::tab blade
```blade
{{ Statamic::modify($description)->regexReplace(['https?://(www.)?([^/]+)/?.*', '\2']) }}
```
::

```html
catvideo.com
```
