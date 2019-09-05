---
title: Section
overview: 'Extract a section of template that can be retrieved in a [Yield Tag](/tags/yield).'
id: 21481d1a-ee1b-4acd-b5ad-65dc7fcec976
---

## Example {#example}

Here's an example template:

```
<h1>{{ title }}</h1>
<div>
    {{ content }}
</div>

{{ section:sidebar }}
    Some sidebar stuff!
{{ /section:sidebar }}
```

Everything within the `section:sidebar` tag pair will _not_ be rendered in this template. It will be rendered
in your layout (or partials within a layout) in the `{{ yield:sidebar }}` tag.

[yield_tag]: /tags/yield
