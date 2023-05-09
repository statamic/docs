---
id: 40578328-3288-4c54-a475-8afad19a37e6
blueprint: modifiers
modifier_types:
  - date
title: Relative
---
Returns a date difference in a nice, human readable, string format. This modifier will add a phrase after the difference value relative to the current date and the passed in date.

You can turn off the extra words "ago", "until", and so on by passing `true` as a parameter

The string will be localized into your current site locale.

```yaml
past_date: October 1 2020
future_date: October 1 2024
```

```
{{ past_date | relative }}
{{ past_date | relative(true) }}
{{ future_date | relative }}
{{ future_date | relative(true) }}
```

```html
2 years ago
2 years
1 year from now
1 year
```
