---
id: b8b51bb8-a4bd-4aec-90bd-4f150a29c8a0
blueprint: fieldtype
title: Width
screenshot: fieldtypes/screenshots/width.png
intro: 'A slick way to select a width in your blueprints. Although you could use it for anything you want as it stores the value in your markdown as an integer. Neat!'
width_field: 50
options:
  -
    name: options
    type: array
    required: false
    description: 'The array of integers presented in the blueprint. Default: 25 / 33 / 50 / 66 / 75 / 100'
  -
    name: default
    type: integer
    required: false
    description: "The default selected width. Can be set to a value that doesn't exist in the options array if desired."
---
## Overview

An alternative to the [Button Group](/fieldtypes/button_group) or [Select](/fieldtypes/select) field types that is a bit more compact and visually appealing.

## Data structure

The selected value is stored as an integer.

``` yaml
image_width: 50
```

## Templating

Use in your front end, most likely with a CSS framework like Tailwind or Bootstrap to set custom widths.

::tabs

::tab antlers

```antlers
<div class="col-12"">
    <div class="w-25">
        <h1>Compact headings</h1>
    </div>
    <div class="w-{{ image_width }}">
        <h2>With wider sub-headings</h2>
    </div>
</div>
```

::tab blade

```blade
<div class="header-block">
	<img class="w-[{{ $image_width }}px] src="/assets/mycoolicon.png>
    <h1>Icon overview</h1>
</div>
```
::