---
id: 44cb7965-877e-49b3-92fe-a24970b542a2
blueprint: modifiers
modifier_types:
  - string
  - utility
title: 'Full Urls'
---
Replaces root-relative URLs with absolute URLs. This is generally used in RSS feeds and other places where markup may be used off the main site.

```md
---
I had this totally [crazy dream](/dream-journal/spiders-with-ramen-legs)
last night and I know you want to hear all about it!
```

```
{{ content | full_urls }}
```

```html
I had this totally [crazy dream](http://example.com/dream-journal/spiders-with-ramen-legs)
last night and I know you want to hear all about it!
```
