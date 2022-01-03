---
id: 18596c62-5535-41a8-91c4-b5769fb11085
blueprint: modifiers
modifier_types:
  - date
parse_content: true
title: 'Modify Date'
---
Alters a timestamp by incrementing or decrementing in a format accepted by PHP's native [`strtotime()`](http://php.net/manual/en/function.strtotime.php) method.


```yaml
date: January 1, 2000
```

```
{{ date modify_date="-1 day" }}
{{ date modify_date="next Sunday" }}
{{ date modify_date="+3 months" }}
```

```html
December 31, 1999
January 2, 2000
April 1, 2000
```

:::tip
This modifier **modifies the variable directly** which will be passed onto any additional modifiers.
:::
