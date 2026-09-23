---
id: c3214196-3d0d-4a3d-b6c3-1ee4960cfe5d
blueprint: modifiers
modifier_types:
  - utility
title: 'To Json'
---
Converts any variable into JSON.

```yaml
stats:
  - player: Luke Skywalker
    score: 750
  - player: Wedge Antilles
    score: 688
  - player: Jar Jar Binks
    score: 1425
```

::tabs

::tab antlers
```antlers
{{ stats | to_json }}
```
::tab blade
```blade
{!! Statamic::modify($stats)->toJson() !!}
```
::

```html
[
  {"player":"Luke Skywalker","score":750},
  {"player":"Wedge Antilles","score":688},
  {"player":"Jar Jar Binks","score":1425}
]
```


## Options

Pass `pretty` to format the output with line breaks and indentation.

Pass `safe` when outputting JSON inside HTML, like a `<script>` tag. It escapes characters such as `<` and `"` so your content can't break out of the markup.

You can combine both:

::tabs

::tab antlers
```antlers
{{ stats | to_json:pretty:safe }}
```
::tab blade
```blade
{!! Statamic::modify($stats)->toJson(['pretty', 'safe']) !!}
```
::
