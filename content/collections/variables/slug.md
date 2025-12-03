---
id: b391facf-5041-498b-a244-0df2359ec30e
blueprint: variables
types:
  - content
title: Slug
description: The string that identifies your content, usually appearing at the end of the URL.
---
A slug is the string that identifies your content. It usually sits at the end of the URL.

::tabs

::tab antlers
```antlers
<h1>{{ title }}</h1>
{{ slug }}
```
::tab blade
```blade
<h1>{{ $title }}</h1>
{{ $slug }}
```
::

```html
<h1>My Thoughts on Bacon</h1>
my-thoughts-on-bacon
```
