---
title: Previous
overview: Grab the previous Pages relative to your current Page.
id: 1172608e-0e75-487a-8cd6-872746542550
---
This Tag functions the same way as the [`pages:next`](/tags/pages-next) tag, but in the opposite direction.

```
{{ pages:previous as="stories" limit="2" }}

  {{ if no_results }}
    No more stories to read!
  {{ /if }}

  {{ stories }}
    <div class="story">
      <a href="{{ url }}">{{ title }}</a>
    </div>
  {{ /stories }}

{{ /pages:previous }}
```
