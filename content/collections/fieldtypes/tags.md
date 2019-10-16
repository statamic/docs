---
title: Tags
screenshot: fieldtypes/tags.png
description: Enter a list of items with a tag-style interface.
overview: >
  Users can enter “taggable” values, which are formatted
  automatically into a YAML list format. It's a lot like the [list fieldtype](/fieldtypes/list) but with a different UI.
stage: 4
id: 821a636f-2ebd-4297-b459-47e702f899df
---
## Overview

You can press `enter`, `tab`, or `,` to add a tag, navigate through tags with your arrow keys; use `backspace` or click the `x` to delete tags, and drag and drop tags to rearrange them. That's all there is to it.

## Data Storage
Your tags will get saved as a simple YAML list, like this:

``` .language-yaml
- delicious
- nutritious
- part of a balanced breakfast
```

## Templating

Loop through the array items to display each item's `value`.

```
<h1>This Cereal Is:</h1>
<ul>
  {{ tags }}
    <li>{{ value }}</li>
  {{ /tags }}
</ul>
```

``` output
<h1>Product Ideas</h1>
<ul>
  <li>delicious</li>
  <li>nutritious</li>
  <li>part of a balanced breakfast</li>
</ul>
```

> This fieldtype uses the word "tags" in general terms. If you're looking for a way to tag/categorize your content on a schema-level, you should read about [taxonomies](/taxonomies).

## Config Options

None. It just does this one thing.
