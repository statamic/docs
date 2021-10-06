---
title: Augmentation
blueprint: page
intro: Augmentation automatically transforms the rendered output of all Blueprint-defined variables based on their fieldtype.
id: 9b2f6f55-5355-4334-b90d-d1236fb58887
---
## Overview

Augmentation is kind of like magic. ✨

For example, while using a [Markdown field](/fieldtypes/modifier), your content will **automatically be converted to HTML** without needing to use a [markdown modifier](/modifiers/markdown). Each [fieldtype](/fieldtypes) documents if and how augmentation affects output.

:::hint
Variables created "on the fly" with Front Matter won't be augmented.
:::

## Example

Let's look at an example with and without augmentation using the following `content`:

``` md
## How to Jump Higher
Bend your knees more and then spring upwards a _lot_ faster.
```

### With Augmentation

If you're using a [Markdown field](/fieldtypes/markdown), the output will be as follows:

```html
<h2>How to Jump Higher</h2>
<p>Bend your knees more and then spring upwards a <em>lot</em> faster.</p>
```

### Without Augmentation

While using a [Textarea field](/fieldtypes/textarea) — which _is not_ augmented — the output will be exactly the same as the as input:

```text
  ## How to Jump Higher
  Bend your knees more and then spring upwards a _lot_ faster.
```

## Digging Deeper

[Learn the inner workings of Augmentation](/extending/augmentation) and how to take advantage of it in your own addons and extensions.
