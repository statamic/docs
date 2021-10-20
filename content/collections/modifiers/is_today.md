---
id: 50aa52bf-8c6c-4ec3-9af7-e610f65f8202
blueprint: modifiers
modifier_types:
  - date
  - conditions
parse_content: true
title: 'Is Today'
---
Returns `true` if date is today - using the server's time.

```yaml
date: {{ now format="F j Y" }}
another_date: November 6 2015
```
{{ noparse }}
```
{{ if date | is_today }}
{{ if another_date | is_today }}
```
{{ /noparse }}

```html
true
false
```
