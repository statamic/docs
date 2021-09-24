---
id: ec6e096f-ee52-449e-96b5-e0d759f982f0
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Remove Right'
---
Ensures that the string never ends with a specified string.

```yaml
urls:
  - http://statamic.com/
  - http://laravel.com/
```

```
{{ urls }}
  {{ value | remove_right:/ }}
{{ /urls}}
```

```html
http://statamic.com
http://laravel.com
```
