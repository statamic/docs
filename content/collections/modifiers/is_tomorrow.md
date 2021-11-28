---
id: 2e700683-1fb1-4cde-a019-67770ceabadf
blueprint: modifiers
title: 'Is Tomorrow'
modifier_types:
  - date
  - conditions
---
Returns `true` if date is tomorrow - using the server's time.

```yaml
date: {{ now modify_date="+1 day" format="F j Y" }}
```
{{ noparse }}
```
{{ if date | is_tomorrow }}
```
{{ /noparse }}

```html
true
```
