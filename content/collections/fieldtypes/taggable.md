---
title: Taggable
screenshot: fieldtypes/tags.png
description: 'Enter a list of items with a tag-style interface.'
overview: |
  Users can enter “taggable” values, which are formatted automatically into a YAML list format. It's a lot like the [list fieldtype](/fieldtypes/list) but with a different UI.
  
stage: 4
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1607013600
id: 821a636f-2ebd-4297-b459-47e702f899df
---
## Overview

Press `enter`, `tab`, or `,` to add a tag. Click an <span class="bg-grey-200 text-grey-600 rounded font-bold px-1">×</span> to remove one. That's  all there is to it.

## Data Storage
Your tags will get saved as a simple YAML list, like this:

``` .language-yaml
- applesauce
- garbage pants
- socks
```

## Templating

Loop through the array items to display each item's `value`.

```
<h1>I've heard rumors of:</h1>
<ul>
  {{ tags }}
    <li>{{ value }}</li>
  {{ /tags }}
</ul>
```

``` output
<h1>I've heard rumors of:</h1>
<ul>
  <li>applesauce</li>
  <li>garbage pants</li>
  <li>socks</li>
</ul>
```

> This fieldtype uses the word "tags" in general terms. If you're looking for a way to tag/categorize your content on a schema-level, you should read about [taxonomies](/taxonomies).

## Config Options

None. It just does this one thing.