---
id: d511b772-bdbe-4d20-9ed9-3c87d72fb946
blueprint: variables
types:
  - content
title: Url
---
Get the URL to the content. This is relative and will _not_ include your site URL.

::tabs

::tab antlers
```antlers
{{ url }}
```
::tab blade
```blade
{{ $url }}
```
::

```html
/posts/bacon
```
