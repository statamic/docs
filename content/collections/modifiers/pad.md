---
id: 0a1595bc-5b41-401c-bb9c-45c35e8e5d7c
blueprint: modifiers
modifier_types:
  - array
title: Pad
---
Pad an array to a given number of items with a value. By default the value is null, but you can specify it as the second parameter.

```yaml
epic_meal_time:
  - jack daniels
  - bacon strips
```

```
{{ epic_meal_time | pad(4, "bacon strips") }}
    {{ value }}
{{ /epic_meal_time }}
```

```html
jack daniels
bacon strips
bacon strips
bacon strips
```
