---
id: bd468407-617a-4cb8-93d8-cfd7148ec157
blueprint: modifiers
modifier_types:
  - date
  - conditions
parse_content: true
title: 'Is Yesterday'
---
Returns `true` if date is yesterday - using the server's time.

```yaml
date: {{ now modify_date="-1 day" format="F j Y" }}
```
{{ noparse }}
```
{{ if date | is_yesterday }}
```
{{ /noparse }}

```html
true
```
