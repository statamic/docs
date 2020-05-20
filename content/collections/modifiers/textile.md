---
modifier_types:
  - markup
attributes: true
id: 53a0c177-ce45-43e6-a166-d21f8baeffab
---
Transform a string with [Textile][textile].

```.language-yaml
quote: You can't wait for inspiration. *You have to go after it with a club.*

```

```
{{ quote | textile }}
```

```.language-output
<p>
    You can't wait for inspiration. <strong>You have to go after it with a club.</strong>
</p>
```

[textile]: http://demo.textilewiki.com/theme-default/
