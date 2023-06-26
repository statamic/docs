---
id: 4cb0f243-72f4-45a1-83d3-d72209907875
blueprint: modifiers
modifier_types:
  - string
  - conditions
title: 'Is External Url'
---
Returns `true` if a string is an external URL.

```yaml
google_url: http://google.com/
entry_url: /waffles
```

```
{{ if google_url | is_external_url }}
{{ if entry_url | is_external_url }}
```

```html
true
false
```