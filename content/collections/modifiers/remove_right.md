---
modifier_types:
  - string
  - utility
id: ec6e096f-ee52-449e-96b5-e0d759f982f0
---
Ensures that the string never ends with a specified string.

```.language-yaml
urls:
  - http://statamic.com/
  - http://laravel.com/
```

```
{{ urls }}
  {{ value | remove_right:/ }}
{{ /urls}}
```

```.language-output
http://statamic.com
http://laravel.com
```
