---
title: Augmentation
stage: 3
id: 9b2f6f55-5355-4334-b90d-d1236fb58887
---
## Overview

Augmentation is a transformation step in Statamic 3's data layer that establishes a connection between your front-end templating and the blueprints that define your content model.

In other words, augmentation automatically transforms the rendered output of each variable based on the fieldtype chosen to manage it.

If you choose a Markdown fieldtype, your content will automatically be converted to Markdown without the need to use a [markdown modifier](/modifiers/markdown).

Each [fieldtype](/fieldtyhpes) documents if and how augmentation affects your output.

> Variables created on the fly with Front Matter won't be augmented until you define them in the entry's [blueprint](/blueprints).

## Example

Let's look at an example with and without augmentation. For the augmented output let's assume that we're using a [Markdown field](/fieldtypes/markdown).

``` yaml
content: |
  ## This is an h2

  And this is a **paragraph** that includes bold text.
```

```
<article>
  {{ content }}
</article>
```

``` output
// With Markdown augmentation
<article>
  <h2>This is an h2</h2>
  <p>And this is a <strong>paragraph</strong> that includes bold text.</p>
</article>

// Without
<article>
  ## This is an h2

  And this is a **paragraph** that includes bold text.
</article>
```
