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
//Assuming 'now' date is December 7th, 2021
---
date: "{{ now }}"
---
```

```template
//template
{{ date | modify_date:last Sunday }}
{{ date | modify_date:+3 months }}
{{ date | modify_date:-2 weeks }}
```

```html
//output
December 5th, 2021
March 7th, 2022
November 23rd, 2021
```

:::tip
This modifier **modifies the variable directly** which will carry over to subsequent modifications, as shown in the above example.
:::
