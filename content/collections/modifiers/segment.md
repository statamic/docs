---
id: 87cb26b4-3eb1-4bd7-8d80-913f1ba21932
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Segment
---
Returns a segment by number from any valid URL or URI.

```yaml
example: /this/is/pretty/neat
```

```
{{ example | segment(4) }}
```

```html
neat
```
