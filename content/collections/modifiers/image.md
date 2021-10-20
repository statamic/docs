---
id: 26045669-567d-4e93-b3ba-34c835f5c5e9
blueprint: modifiers
modifier_types:
  - asset
  - markup
attributes: true
title: Image
---
Generate an HTML image element with the variable's value as `src`.

```yaml
header_image: /assets/img/bokeh-bunnies.jpg
```

```
{{ header_image | image }}
```

```html
<img src="/assets/img/bokeh-bunnies.jpg">
```
