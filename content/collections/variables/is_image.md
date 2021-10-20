---
id: 89e75dec-7f33-4217-b040-dc2a18de5d83
blueprint: variables
types:
  - asset
title: 'Is Image'
---
A boolean for whether the asset is an image.

```
{{ if is_image }}
    <img src="{{ url }}" />
{{ else }}
    <a href="{{ url }}">Download</a>
{{ /if }}
```
