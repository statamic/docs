---
types:
- asset
  - markup
attributes: true
id: 26045669-567d-4e93-b3ba-34c835f5c5e9
---
Generate an HTML image element with the variable's value as `src`.

```.language-yaml
header_image: /assets/img/bokeh-bunnies.jpg
```

```
{{ header_image | image }}
```

```.language-output
<img src="/assets/img/bokeh-bunnies.jpg">
```
