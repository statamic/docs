---
id: cbf3a055-9714-4f0f-a33b-508c59b4e1f8
types:
  - global
---
The current date/time. If you use it on its own, it will be formatted using the default time format. If you pass it into a tag parameter or modifier, it will be treated as the `Carbon` instance.

```
{{ now }}
```

``` .language-output
December 30th 2015
```

Also available as `{{ today }}` and `{{ current_date }}` aliases.
