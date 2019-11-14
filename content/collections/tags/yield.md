---
title: Yield
description: 'Displays content extracted elsewhere by the section tag'
intro: 'The yield tag is a useful way to abstract and reuse your views by displaying content or markup extracted in a template by the [section tag](/tags/section).'
stage: 4
id: f3035f71-347e-4b99-bc27-71956315692a
---
## Overview

Most commonly this section/yield approach is used to create a global area in your layout that can be changed by your templates. This eliminates the need for any brittle and messy logic.

**Cheatsheet:**

- <span class="text-red font-bold">No thank you:</span> `{{ if template == "news" }} hardcode something {{ /if }}`
- <span class="text-green font-bold">Yes please:</span> `{{ yield:something }}` + `{{ section:something }}`

## Example

In the example below, everything within the `section:sidebar` tag will _not_ be rendered in the template, but rather in the layout.

```
// The Template

<h1>{{ title }}</h1>
{{ content }}

{{ section:sidebar }}
  <h2>About the Author</h2>
  <div>
    {{ author:name }}
  </div>
  {{ author:bio }}
{{ /section:sidebar }}
```

```
// The Layout
<html>
  <head>
    <title>{{ title }} | {{ site_name }}</title>
  </head>
  <body>
    <article>
      {{ template_content }}
    </article>
    <aside>
      {{ yield:sidebar }}
    </aside>
  </body>
</html>
```

## Fallback Content

If no section is being pushed into the yield, you may display fallback content by using the tag as a pair.

```
<aside>
  {{ yield:sidebar }}
    <img src="/img/CLIPPY.GIF">
    <p>Hi! It looks like you're building a website. Would you like help?</p>
  {{ /yield:sidebar }}
</aside>
```

## Related Reading

If you haven't read up on [templates and layouts](/views), you should. It's relevant.


[yield_tag]: /tags/yield
