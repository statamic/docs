---
id: 53a0c177-ce45-43e6-a166-d21f8baeffab
blueprint: modifiers
modifier_types:
  - markup
attributes: true
title: Textile
---
Transform a string with [Textile][textile].

```yaml
quote: You can't wait for inspiration. *You have to go after it with a club.*

```

```
{{ quote | textile }}
```

```html
<p>
    You can't wait for inspiration. <strong>You have to go after it with a club.</strong>
</p>
```

[textile]: http://demo.textilewiki.com/theme-default/
