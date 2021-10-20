---
id: d3ab4cb6-2aeb-4a15-93b9-79e56ad82223
blueprint: modifiers
modifier_types:
  - string
title: 'Is Embeddable'
---
Checks to see if a video URL is embeddable. ie. If it is a YouTube or Vimeo URL.

Plays nicely with the [Video fieldtype](/fieldtypes/video) and the [embed_url modifier](/modifiers/embed_url).

```yaml
youtube: https://www.youtube.com/watch?v=s9F5fhJQo34
vimeo: https://vimeo.com/22439234
other: http://example.com/video.mp4
```

```
{{ youtube | is_embeddable }}
{{ vimeo | is_embeddable }}
{{ other | is_embeddable }}
```

```html
true
true
false
```
