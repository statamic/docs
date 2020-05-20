---
modifier_types:
  - string
id: 45310885-fbd3-438d-85d5-076dda1646e0
---
Converts a Youtube or Vimeo link to their embed URLs.

Plays nicely with the [Video fieldtype](/fieldtypes/video) and the [is_embeddable modifier](/modifiers/is_embeddable).

``` .language-yaml
youtube: https://www.youtube.com/watch?v=s9F5fhJQo34
vimeo: https://vimeo.com/22439234
other: http://example.com/video.mp4
```

```
{{ youtube | embed_url }}
{{ vimeo | embed_url }}
{{ other | embed_url }}
```

``` .language-output
https://www.youtube.com/embed/s9F5fhJQo34
https://player.vimeo.com/video/22439234
http://example.com/video.mp4
```
