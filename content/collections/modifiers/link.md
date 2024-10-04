---
id: 16312447-a597-4a98-9726-8e97718c9788
blueprint: modifiers
modifier_types:
  - markup
attributes: true
title: Link
---
Generate an HTML link element with the value as `href`.

```yaml
neat_site: http://example.com
```

::tabs

::tab antlers
```antlers
{{ neat_site | link }}
```
::tab blade
```blade
{{ Statamic::modify($neat_site)->link() }}
```
::

```html
<a href="http://example.com">http://example.com</a>
```
