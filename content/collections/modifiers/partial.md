---
id: 23d51738-5043-49e3-8ca3-d5848427216f
blueprint: modifiers
modifier_types:
  - utility
  - string
  - array
title: Partial
---
Inject a variable's data into a partial and render it without any page scopes whatsoever. This is really just syntactical sugar, but it _is_ delicious.

```yaml
data:
  title: Bubble Guppies
  content: Science died a little bit today.
```

```antlers
{{# resources/partials/demo.html #}}
<h1>{{ title }}</h1>
{{ content | markdown }}

{{# Template markup #}}
{{ data | partial('demo') }}
```

This modifier reads from `resources/partials/`. For partials in your normal `resources/views/` directory, use the [partial tag](/tags/partial).

```html
<h1>Bubble Guppies</h1>
<p>Science died a little bit today.</p>
```
