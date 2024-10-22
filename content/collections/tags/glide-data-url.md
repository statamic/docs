---
title: "Glide:Data_URL"
description: Manipulates an image and returns a data URL
stage: 4
intro: Use `glide:data_url` to output a manipulated image as a Data URL.
parameters:
  -
    name: src|path|id
    type: string
    description: >
      The URL of the image when _not_ using the shorthand syntax. (Use the shorthand syntax if you can, it's nicer.)
      This also accepts asset IDs, if using [private assets](/assets#private-assets), for example.
  -
    name: tag
    type: boolean *false*
    description: When set to true, this will output an `<img>` tag with the URL in the `src` attribute, rather than just the URL.
  -
    name: alt
    type: string
    description: When using the `tag` parameter, this will insert the given text into the `alt` attribute.
  -
    name: preset
    type: string
    description: >
      Use a preset of pre-configured parameters. [Learn more](#presets).
id: 41698c83-5ca0-43eb-88ad-96343dea12ef
---
## Overview

The `{{ glide:data_url }}` tag works in a very similar way to the standard [Glide tag](/tags/glide), except it outputs the manipulated as a [Data URL](https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/Data_URLs).

## Example

You may pass any parameters you'd [normally pass to the Glide tag](/tags/glide#parameters), like `width`, `height` and `format`.

::tabs

::tab antlers
```antlers
{{ glide:data_url src="image.jpg" width="1280" height="800" format="webp" }}
```
::tab blade
```blade
{{
  Statamic::tag('glide:data_url')
    ->src('image.jpg')
    ->width(1280)
    ->height(800)
    ->format('webp')
}}
```
::

```output
data:image/webp;base64,R0lGODlhAgACAJEAALwWrOQqhOwqhP///yH5BAEAAAMALAAAAAACAAIAAAIDBBIFADs=
```
