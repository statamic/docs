---
id: 0904f610-eee8-4b86-827b-0dc281d553ca
blueprint: modifiers
modifier_types:
  - asset
  - string
title: 'Background Position'
---
Converts an asset focal point value (eg. `50-30`) into a value suitable for the background-position css property.

```.language-yaml
focus: 50-30
```

```
background-position: {{ focus | background_position }};
```

```.language-output
background-position: 50% 30%;
```
