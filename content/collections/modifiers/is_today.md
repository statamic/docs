---
id: 50aa52bf-8c6c-4ec3-9af7-e610f65f8202
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Today'
---
Returns `true` if a given date is today, using the server's time.

```yaml
date: January 1, 2000
```

```
{{ if date | is_today }}
```

```html
false
```
