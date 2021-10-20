---
id: fbf6eab4-0769-4e13-9205-f9f64fd44572
blueprint: modifiers
modifier_types:
  - date
  - conditions
title: 'Is Past'
---
Returns `true` if date is in the past.

```yaml
date: October 21 2015
another_date: November 2019
```

```
{{ if date | is_past }}
{{ if another_date | is_past }}
```

```html
true
false
```
