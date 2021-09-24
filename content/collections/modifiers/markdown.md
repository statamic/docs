---
id: 39dcb2b1-a319-4a0b-b7d0-5c7a1b8aa31b
blueprint: modifiers
modifier_types:
  - markup
attributes: true
title: Markdown
---
Transform a string with [Markdown][markdown].

```yaml
quote: You can't wait for inspiration. **You have to go after it with a club.**

```

```
{{ quote | markdown }}
```

```html
<p>
    You can't wait for inspiration. <strong>You have to go after it with a club.</strong>
</p>
```

[markdown]: https://daringfireball.net/projects/markdown/
