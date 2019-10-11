---
title: Markdown
intro: Write and preview Markdown with the help of formatting buttons and other neat things.
screenshot: fieldtypes/markdown.png
id: 607cfe62-7239-461b-8f55-8e7a312c2d5d
options:
  -
    name: container
    type: string
    description: >
      An asset container ID. When specified, the fieldtype will allow the user to add assets from the specified container.
  -
    name: folder
    type: string
    description: >
      The folder (relative to the asset container) to use when choosing assets. If left blank, the root folder of the container will be used.
  -
    name: restrict_assets
    type: bool
    description: >
      If set to `true`, navigation within the asset browser dialog will be disabled, and you
      will be restricted to the container and folder specified.
  -
    name: cheatsheet
    type: bool
    description: >
      If set to `true`, display a link to open a Markdown cheatsheet from the specified field.
---
## Overview

- Markdown is great because (reasons)
- Field has a preview button, fullscreen, and cheatsheet helper
- We're using [Parsedown] with the [Parsedown Extra][extra] extension enabled.

## Data Structure

The data will be saved exactly as written – as Markdown.

## Templating

The Markdown string will automatically be transformed into HTML through [augmentation](/augmentation). You need only to the use the variable and the rest is done for you.

``` yaml
content: '**Bold** move, Cotton.'
```

```
{{ content }}
```

``` output
<p><strong>Bold</strong> move, Cotton.</p>
```

## Config Options

[parsedown]: https://parsedown.org/
[extra]: https://github.com/erusev/parsedown-extra
