---
id: 26045669-567d-4e93-b3ba-34c835f5c5e9
blueprint: modifiers
modifier_types:
  - asset
  - markup
attributes: true
title: Image
---
Generate an HTML image element with the variable's value as `src`.

```yaml
header_image: /assets/img/bokeh-bunnies.jpg
```

::tabs

::tab antlers
```antlers
{{ header_image | image }}
{{ header_image | image('class:width-50') }}
```
::tab blade
```blade
{!! Statamic::modify($header_image)->image() !!}
{!! Statamic::modify($header_image)->image('class:width-50') !!}
```
::
```html
<img src="/assets/img/bokeh-bunnies.jpg">
<img src="/assets/img/bokeh-bunnies.jpg" class="width-50">
```
