---
title: Generate
id: 0af9e798-850e-427e-8c04-f065185b1b86
overview: Generate images with a tag pair syntax that exposes variables.
parameters:
  -
    name: src|id
    type: string
    description: The ID of the asset.
  -
    name: path
    type: string
    description: The path to an image, if you don't want to use assets. This should be relative to your webroot, eg. `/assets/photo.jpg`
variables:
  -
    name: url
    type: string
    description: The URL of the resized image.
  -
    name: width
    type: integer
    description: The width of the resized image.
  -
    name: height
    type: integer
    description: The height of the resized image.
---
## Usage
This tag is similar to the [Glide Tag][glide_tag] with a few differences:

- It's a tag pair.
- There's no shorthand syntax.
- Images are generated immediately.

This tag can be useful if you need to know the dimensions of the resized image before it's rendered.

## Example

We have an image's asset ID saved in the YAML, and we want to resize it to 300x200, fit it inside the area by cropping it, and apply a sepia filter.

``` language-yaml
image: "380dc8d9-481c-4d18-9162-ecd5688f98a8"
```

```
{{ glide:generate src="{image}" width="300" height="200" fit="crop" filter="sepia" }}
  <img src="{{ url }}" width="{{ width }}" height="{{ height }}" />
{{ /glide:generate }}
```

``` .language-output
/img/id/380dc8d9-481c-4d18-9162-ecd5688f98a8?w=300&h=200&fit=crop&filt=sepia&s=3982hf983f2mf90r23
```

[glide_tag]: /tags/glide
