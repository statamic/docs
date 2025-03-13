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

::tabs

::tab antlers
```antlers
{{ urls }}
  {{ value | remove_right('/') }}
{{ /urls}}
```
::tab blade
```blade
@foreach ($urls as $url)
  {{ Statamic::modify($url)->removeRight('/') }}
@endforeach
```
::

```html
http://statamic.com
http://laravel.com
```
