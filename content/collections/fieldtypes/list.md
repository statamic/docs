---
title: List
description: Manage simple lists with the help of a keyboard-friendly interface.
intro: >
  Create YAML lists with a robust user interface. It has full keyboard controls
  so you can use `up` to go up, `down` to go down, drag and drop to rearrange the order, and click an item to select it and begin editing.
screenshot: fieldtypes/screenshots/v4/list.png
id: bd079cba-c5d2-475d-ae82-57874818858e
---
## Overview

For when you want to manage a simple YAML list, this fieldtype is here for you. Being able to reorder the list items is nice, as is the ability to delete them.

## Data Storage

``` yaml
product_ideas:
  - 'Knife-Wrench (for kids!)'
  - 'Kite-Fork'
  - 'Apple-Cranberry hybrid (calling it Appleberry™)'
```

## Templating

Loop through the array items to display each item's `value`.

```
<h1>Product Ideas</h1>
<ul>
  {{ product_ideas }}
    <li>{{ value }}</li>
  {{ /product_ideas }}
</ul>
```

```html
<h1>Product Ideas</h1>
<ul>
  <li>Knife-Wrench (for kids!)</li>
  <li>Kite-Fork</li>
  <li>Apple-Cranberry hybrid (calling it Appleberry™)</li>
</ul>
```
