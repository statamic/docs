---
id: f3538ff6-b658-45d0-b3e0-fbac49f05da9
blueprint: modifiers
modifier_types:
  - markup
  - string
  - utility
title: 'Strip Tags'
---
Strip HTML tags from a string, allowing you optionally to pass in a list of tags or a variable name containing the specific tags you want stripped.

```yaml
html: >
  <blockquote><p>"Things we lose have a way of coming back to us in the end,
  if not always in the way we expect."</p></blockquote>

unwanted: [p, blockquote]
```

```
{{ html | strip_tags }}
{{ html | strip_tags('p') }}
{{ html | strip_tags($unwanted) }}
```

```html
"Things we lose have a way of coming back to us in the end,
if not always in the way we expect."

<blockquote>
  "Things we lose have a way of coming back to us in the end,
  if not always in the way we expect."
</blockquote>

"Things we lose have a way of coming back to us in the end,
if not always in the way we expect."
```
