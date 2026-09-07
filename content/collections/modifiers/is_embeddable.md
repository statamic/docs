---
id: d3ab4cb6-2aeb-4a15-93b9-79e56ad82223
blueprint: modifiers
modifier_types:
  - string
title: 'Is Embeddable'
---
Recognizes YouTube and Vimeo URLs as supported embed sources. This does not check whether the video exists or whether its owner permits embedding.

Plays nicely with the [Video fieldtype](/fieldtypes/video) and the [embed_url modifier](/modifiers/embed_url).

```yaml
youtube: https://www.youtube.com/watch?v=s9F5fhJQo34
vimeo: https://vimeo.com/22439234
other: http://example.com/video.mp4
```

::tabs

::tab antlers
```antlers
{{ youtube | is_embeddable }}
{{ vimeo | is_embeddable }}
{{ other | is_embeddable }}
```
::tab blade
```blade
@if (Statamic::modify($youtube)->isEmbeddable()->fetch()) ... @endif
@if (Statamic::modify($vimeo)->isEmbeddable()->fetch()) ... @endif
@if (Statamic::modify($other)->isEmbeddable()->fetch()) ... @endif
```
::

```html
true
true
false
```
