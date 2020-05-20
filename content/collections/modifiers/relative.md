---
modifier_types:
  - date
id: 40578328-3288-4c54-a475-8afad19a37e6
parse_content: true
---
Returns a date difference in a nice, human readable, string format. This modifier will add a phrase after the difference value relative to the current date and the passed in date.

You can turn off the extra words "ago", "until", and so on by passing `false` as a parameter

The string will be localized into your current site locale.

```.language-yaml
past_date: October 1 2015
future_date: October 1 2019
```

{{ noparse }}
```
{{ past_date | relative }}
{{ future_date | relative }}
{{ past_date | relative:false }}
```
{{ /noparse }}

```.language-output
{{ test_date | relative }}
{{ test_future_date | relative }}
{{ test_date | relative:false }}
```
