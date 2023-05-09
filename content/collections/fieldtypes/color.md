---
title: Color
description: 'Manage colors by hex code with swatches and text inputs.'
intro: 'A simple color picker with support for pre-defined swatches as well as entering a color by hex code.'
screenshot: fieldtypes/screenshots/color.png
options:
  -
    name: swatches
    type: array
    description: |
      Pre-define colors that can be selected from a list. Supports all color mode formats.
  -
    name: allow_any
    type: boolean
    description: |
      Allow entering any color value via picker or hex code.
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


