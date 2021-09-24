---
title: "Markdown:Indent"
id: d26ec250-460e-11e7-9598-0800200c9a66
description: Transforms inline Markdown while ignoring whitespace
intro: This tag is used for transforming Markdown while ignoring whitespace in your view files.
stage: 4
---
## Example {#example}

```
<article class="mx-auto max-w-lg">
  {{ markdown:indent }}
    # My Favorite Nickelodeon Shows

    - Kenan & Kel
    - All That
    - Double Dare
    - Wild & Crazy Kids
    - Legends of the Hidden Temple
  {{ /markdown:indent }}
  </article>
```

```html
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
