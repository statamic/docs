---
id: 44cb7965-877e-49b3-92fe-a24970b542a2
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Full Urls'
---
Replaces root-relative URLs inside HTML attributes (e.g. `href` and `src` ) with absolute URLs. This is most often used in RSS feeds and other places where markup may be consumed off the domain.

```html
I had this totally <a href="/dreams/spiders-with-ramen-legs">crazy dream</a> last night and I know you want to hear all about it!
```

::tabs

::tab antlers
```antlers
{{ content | full_urls }}
```
::tab blade
```blade
{!! Statamic::modify($content)->fulLUrls() !!}
```
::

```html
I had this totally <a href="https://example.com/dreams/spiders-with-ramen-legs">crazy dream</a> last night and I know you want to hear all about it!
```
