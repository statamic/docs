---
id: 9b9a3494-ebb0-4e28-95d3-6d7986b0386e
blueprint: modifiers
modifier_types:
  - string
  - utility
title: Sanitize
---
Convert special characters to HTML entities with [htmlspecialchars][htmlspecialchars].

```yaml
example: <b>NEAT</b>
```

```
{{ example | sanitize }}
```

```html
&lt;b&gt;NEAT&lt;b&gt;
```

## Double Encoding

You can double encode HTML entities by passing `true` as an argument. This is useful for preserving JSON formatting.

```
{{ example | sanitize:true }}
```

[htmlspecialchars]: http://php.net/manual/en/function.htmlspecialchars.php
