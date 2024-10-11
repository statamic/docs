---
id: f1b59bce-43e7-41a4-b82f-e16016d90b18
blueprint: modifiers
modifier_types:
  - string
  - utility
title: CDATA
---
Wraps a string in [CDATA][cdata] tags, useful for formatting characters properly in XML.

```yaml
title: My Very Own Podcast
```

::tabs

::tab antlers
```antlers
{{ title | cdata }}
```
::tab blade
```blade
{!! Statamic::modify($title)->cdata() !!}
```
::

```html
<![CDATA[My Very Own Podcast]]>
```

[cdata]: https://en.wikipedia.org/wiki/CDATA
