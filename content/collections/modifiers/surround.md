---
id: 1fea97b2-c42f-495b-846a-6c688d3b5eca
blueprint: modifiers
modifier_types:
  - string
title: Surround
---
Surrounds a string with another string.

```yaml
string:  ͜
```

```
{{ string | surround('ʘ') }}
```

```html
ʘ ͜ ʘ
```
