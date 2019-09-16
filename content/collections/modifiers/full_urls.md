---
types:
  - string
  - utility
id: 44cb7965-877e-49b3-92fe-a24970b542a2
---
Replaces root-relative URLs with absolute URLs. This is generally used in RSS feeds and other places where markup may be used off the main site.

```.language-markdown
---
I had this totally [crazy dream](/dream-journal/spiders-with-ramen-legs)
last night and I know you want to hear all about it!
```

```
{{ content | full_urls }}
```

```.language-output
I had this totally [crazy dream](http://example.com/dream-journal/spiders-with-ramen-legs)
last night and I know you want to hear all about it!
```
