---
title: Augmentation
blueprint: page
id: 9b2f6f55-5355-4334-b90d-d1236fb58887
---
## Overview

Augmentation is a transformation step in Statamic 3's data layer which establishes a connection between your front-end templates and the blueprints defining your content model.

In other words, augmentation automatically transforms the rendered output of each variable based on the fieldtype chosen to manage it.

If you choose a Markdown fieldtype, your content will automatically be converted to HTML without the need to use a [markdown modifier](/modifiers/markdown).

Each [fieldtype](/fieldtypes) documents if and how augmentation affects your output.

:::hint
Variables created on the fly with Front Matter won't be augmented unless you define them in the entry's [blueprint](/blueprints).
::

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

If you're using a [Textarea field](/fieldtypes/textarea) — which _is not_ augmented — the output will exactly as input:

```text
  ## How to Jump Higher
  Bend your knees more and then spring upwards a _lot_ faster.
```

## Digging Deeper

[Learn the inner workings of Augmentation](/extending/augmentation) and how to use it in your own addons and extensions.
