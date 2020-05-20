---
modifier_types:
  - markup
attributes: true
id: 16312447-a597-4a98-9726-8e97718c9788
---
Generate an HTML link element with the value as `href`.

```.language-yaml
neat_site: http://example.com
```

```
{{ neat_site | link }}
```

```.language-output
<a href="http://example.com">http://example.com</a>
```
