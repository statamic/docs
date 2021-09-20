---
id: f1b59bce-43e7-41a4-b82f-e16016d90b18
blueprint: modifiers
modifier_types:
  - string
  - utility
title: CDATA
---
Wraps a string in [CDATA][cdata] tags, useful for formatting characters properly in XML.

```.language-yaml
title: My Very Own Podcast
```

```
{{ title | cdata }}
```

```.language-output
<![CDATA[My Very Own Podcast]]>
```

[cdata]: https://en.wikipedia.org/wiki/CDATA
