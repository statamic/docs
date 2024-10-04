---
id: 45310885-fbd3-438d-85d5-076dda1646e0
blueprint: modifiers
modifier_types:
  - string
title: 'Embed Url'
---
Converts a Youtube or Vimeo link to their embed URLs.

Plays nicely with the [Video fieldtype](/fieldtypes/video) and the [is_embeddable modifier](/modifiers/is_embeddable).

```yaml
youtube: https://www.youtube.com/watch?v=s9F5fhJQo34
vimeo: https://vimeo.com/22439234
other: http://example.com/video.mp4
```

::tabs

::tab antlers
```antlers
{{ youtube | embed_url }}
{{ vimeo | embed_url }}
{{ other | embed_url }}
```
::tab blade
```blade
{{ Statamic::modify($youtube)->embedUrl() }}
{{ Statamic::modify($vimeo)->embedUrl() }}
{{ Statamic::modify($other)->embedUrl() }}
```
::

```html
https://www.youtube.com/embed/s9F5fhJQo34
https://player.vimeo.com/video/22439234
http://example.com/video.mp4
```
