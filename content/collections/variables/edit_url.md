---
id: 4b4bd7a7-6fc8-4457-b030-56d4474e20b0
blueprint: variables
types:
  - content
title: 'Edit Url'
---
Get the URL to edit the current page or entry in the Control Panel, if there is one (for example, there is no `edit_url` for a template route).

The user will need to login and have permissions, so it's probably best if used in conjunction with [permissions checks](/tags/user-can).

```
<a href="{{ edit_url }}">Edit this page</a>
```

```html
<a href="/cp/pages/edit/about-ye-old-me">Edit this page</a>
```
