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
message: 'This is a great video: https://www.youtube.com/watch?v=YO_spdAYjPk'
```

::tabs

::tab antlers
```antlers
{{ message | regex_replace('watch\?v=[\w-]+', 'watch?v=dQw4w9WgXcQ') }}
```
::tab blade
```blade
{{ Statamic::modify($message)->regexReplace(['watch\?v=[\w-]+', 'watch?v=dQw4w9WgXcQ']) }}
```
::

```html
Check out this video: https://www.youtube.com/watch?v=eBGIQ7ZuuiU
```

Great for when your client keeps putting YouTube links in their content and you want to, uh, help them out.
