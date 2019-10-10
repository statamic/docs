---
title: Color
description: 'Pick colors, enter hex or HSLA values, and other colorful things.'
intro: 'This fieldtype is a highly configurable color picker with simple and advanced UI modes, support for alpha channel, rgba, hsla, hsva, and more.'
screenshot: fieldtypes/color.png
options:
  -
    name: theme
    type: string
    description: |
      Choose between a `classic` and a simpler `nano` (mini) theme. Default: `classic`.

  -
    name: color_mode
    type: array
    description: |
      Choose which color modes you want to enable in the UI. Available choices: `hex`, `rgba`, `hsla`, `hsva`, and `cmyk`. Default: `hex`.
  -
    name: default_color_mode
    type: string
    description: |
      Set which color mode you wish to be the default. Default: `hex`.

  -
    name: swatches
    type: array
    description: |
      Pre-define colors that can be selected from a list. Supports all color mode formats.
stage: 3
id: 09b4af2d-265a-49ee-ac74-3e27041c180b
---
## Overview

If you want work with colors, this is the way to do it. You could combine it with [Bard](/fieldtypes/bard) or [Replicator](/fieldtypes/replicator) to create page "page builders", use it to choose background colors for headers or hero blocks, or even image overlays with `mix-blend-mode: multiply`. Go get creative!

## Data Structure

The color fieldtype stores the color values as a hex string.

``` yaml
header_color: "#FF269E"
```

## Templating

The color is output as a simple string. Most often you'll use this in an inline `style` tag to style elements of your front-end site.

```
<div class="hero" style="background-color: {{ header_color }}">
  <h1>Bay Side High's Sweetheart Dance</h1>
  <h2>This Friday Night!</h2>
</div>
```

## Config Options
