---
title: Markdown
id: 3f0e8d63-f6ca-4a8e-86dd-8361aa328807
description: Transforms inline Markdown written in your view files
intro: The Markdown tag is used for transforming inline Markdown written in your view files.
stage: 5
---
## Example

```
<article class="mx-auto max-w-lg">
{{ markdown }}
# My Favorite Nickelodeon Shows

- Kenan & Kel
- All That
- Double Dare
- Wild & Crazy Kids
- Legends of the Hidden Temple
{{ /markdown }}
</article>
```

``` output
<article class="mx-auto max-w-lg">
<h1>My Favorite Nickelodeon Shows</h1>
<ul>
  <li>Kenan & Kel</li>
  <li>All That</li>
  <li>Double Dare</li>
  <li>Wild & Crazy Kids</li>
  <li>Legends of the Hidden Temple</li>
</ul>
</article>
```

> Markdown considers indentation to be a code block. You'll need to keep your content flush left or use the [markdown:indentation](/tags/markdown-indentation) tag.
