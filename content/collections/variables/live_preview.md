---
id: e722fd36-1aa5-4e91-8eeb-8b759accf4d2
blueprint: variables
types:
  - system
title: 'Live Preview'
related_entries:
  - cdffd2c9-cf42-495d-a8f1-f416ddfddc29
---

A boolean for whether the current page is being viewed in [Live Preview](/live-preview).

```antlers
{{ if live_preview }}
    <div>If you are seeing this, you're in Live Preview 😎</div>
{{ /if }}
```
