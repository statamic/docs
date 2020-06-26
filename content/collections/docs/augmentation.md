---
title: Augmentation
stage: 3
id: 9b2f6f55-5355-4334-b90d-d1236fb58887
---
## Overview

Augmentation is a transformation step in Statamic 3's data layer which establishes a connection between your front-end templates and the blueprints defining your content model.

In other words, augmentation automatically transforms the rendered output of each variable based on the fieldtype chosen to manage it.

If you choose a Markdown fieldtype, your content will automatically be converted to HTML without the need to use a [markdown modifier](/modifiers/markdown).

Each [fieldtype](/fieldtypes) documents if and how augmentation affects your output.

> Variables created on the fly with Front Matter won't be augmented until you define them in the entry's [blueprint](/blueprints).

## Example

Let's look at an example with and without augmentation. For the augmented output let's assume we're using a [Markdown field](/fieldtypes/markdown).

``` yaml
content: |
  ## How to Jump Higher

  Bend your knees more and then spring upwards a _lot_ faster.
```

```
// With Markdown augmentation
<article>
  {{ content }}
</article>

// Without
<article>
  {{ content | raw }}
</article>
```

``` output
// With Markdown augmentation
<article>
  <h2>How to Jump Higher</h2>
  <p>Bend your knees more and then spring upwards a <em>lot</em> faster.</p>
</article>

// Without
<article>
  ## How to Jump Higher

  Bend your knees more and then spring upwards a _lot_ faster.
</article>
```

## Digging Deeper

[Learn the inner workings of Augmentation](/extending/augmentation) and how to use it in your own code over in the Extending Statamic docs.
