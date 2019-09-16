---
types:
  - markup
  - string
  - utility
id: f3538ff6-b658-45d0-b3e0-fbac49f05da9
---
Strip HTML tags from a string, allowing you optionally to pass in a list of tags or a variable name containing the specific tags you want stripped.

```.language-yaml
html: >
  <blockquote><p>"Things we lose have a way of coming back to us in the end,
  if not always in the way we expect."</p></blockquote>

unwanted: [p, blockquote]
```

```
{{ html | strip_tags }}
{{ html | strip_tags:p }}
{{ html | strip_tags:unwanted }}
```

```.language-output
"Things we lose have a way of coming back to us in the end,
if not always in the way we expect."

<blockquote>
  "Things we lose have a way of coming back to us in the end,
  if not always in the way we expect."
</blockquote>

"Things we lose have a way of coming back to us in the end,
if not always in the way we expect."
```
