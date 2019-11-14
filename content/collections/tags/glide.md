---
title: Glide
description: Manipulates images on the fly
intro: The Glide tag makes it easy to manipulate images on the fly – from resizing and cropping to adjustments (like sharpness and contrast) and image effects (like pixelate and sepia).
template: tags.glide
blueprint: tag-glide
stage: 4
parameters:
  -
    name: src|path|id
    type: string
    description: >
      The URL of the image when _not_ using the shorthand syntax. (Use the shorthand syntax if you can, it's nicer.)
      This also accepts asset IDs, if using [private assets](/assets#private-assets), for example.
  -
    name: field
    type: tag part
    description: 'The name of the field containing the asset ID or image path when using the shorthand syntax. This is not actually a parameter, but part of the tag itself. For example, `{{ glide:hero_image }}`.'
  -
    name: tag
    type: boolean *false*
    description: When set to true, this will output an `<img>` tag with the URL in the `src` attribute, rather than just the URL.
  -
    name: alt
    type: string
    description: When using the `tag` parameter, this will insert the given text into the `alt` attribute.
  -
    name: absolute
    type: 'boolean *false*'
    description: >
      When set to `true`, this tag will output the full URL rather than the default relative URL.
shape:
  -
    name: width
    type: integer
    description: >
      Sets the width of the image, in pixels.
  -
    name: height
    type: integer
    description: >
      Sets the height of the image, in pixels.
  -
    name: square
    type: integer
    description: >
      A shortcut for setting `width` and `height` to the same value.
  -
    name: fit
    type: string
    description: >
      See the [Glide docs](http://glide.thephpleague.com/1.0/api/size/#fit-fit) on this parameter. In addition to the
      Glide's fit options, Statamic also supports `crop_focal` to automatically fit/crop to a predefined focal point.
      See the [_Focal Crop_](#focal-crop) section for more details.
  -
    name: crop
    type: string
    description: >
      Crops the image to specific dimensions prior to any other resize operations. Required format: `width,height,x,y`.
  -
    name: orient
    type: mixed
    description: >
      Rotates the image. Accepts `auto`, `0`, `90`, `180` or `270`. The `auto` option uses Exif data to automatically orient images correctly. Default: `auto`.
  -
    name: quality
    type: integer
    description: >
      Defines the quality of the image. Use values between `0` and `100`. Only relevant if the format is `jpg` or `pjpg`. Default: `90`.
  -
    name: format
    type: string
    description: >
      Encodes the image to a specific format. Accepts `jpg`, `pjpg` (progressive jpeg), `png` or `gif`. Default: `jpg`.

filters:
  -
    name: bg
    type: string
    description: >
      Sets a background color for transparent images.
  -
    name: blur
    type: integer
    description: >
      Adds a blur effect to the image. Use values between `0` and `100`.
  -
    name: brightness
    type: string
    description: >
      Adjusts the image brightness. Use values between `-100` and `+100`, where `0` represents no change.
  -
    name: contrast
    type: string
    description: >
        Adjusts the image contrast. Use values between `-100` and `+100`, where `0` represents no change.
  -
    name: gamma
    type: float
    description: >
      Adjusts the image gamma. Use values between `0.1` and `9.99`.
  -
    name: sharpen
    type: integer
    description: >
      Sharpen the image. Use values between `0` and `100`.
  -
    name: pixelate
    type: integer
    description: >
      Applies a pixelation effect to the image. Use values between `0` and `1000`.
  -
    name: filter
    type: string
    description: >
      Applies a filter effect to the image. Accepts `greyscale` or `sepia`.
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
id: b70a3d9a-6605-446e-b278-de99ba561fe0
---
## Overview

The Glide tag leverages the fantastic [Glide](http://glide.thephpleague.com/) PHP library to give you on-demand image manipulation, similar to cloud image processing services like [Imgix](https://www.imgix.com/) and [Cloudinary](https://cloudinary.com/).


Manipulate images by passing a variable or an explicit URL and adding the desired [parameters](#parameters) like `height`, `crop`, or `quality`.

```
// Variable
<img src="{{ glide:hero_image width="1280" height="800" }}">

// URL
<img src="{{ glide src="/img/heroes/slime.jpg" width="1280" height="800" }}">
```


## Tag Pair

If you use the tag as a pair, you'll have access to `url`, `height`, and `width` variables inside to do with as you wish.

```
{{ glide:image width="600" }}
    <img src="{{ url }}" width="{{ width }}" height="{{ height }}">
{{ /glide:image }}
```

## Focal Point Cropping

Focal point cropping helps ensure the important bits of an image stay in the bounds of any crops you perform.

### Using the focal point picker

You can set focal points and zoom-levels for your images in the control panel using the asset editor. Use `fit="crop_focal"` while cropping to use an asset's saved focal point, if it has one.

<figure>
  <img src="/img/focal-point-picker.jpg" alt="The Focal Point Picker">
  <figcaption>The focal point picker. Make sure to keep that hair in the shot!</figcaption>
</figure>

### Manually setting focal points

When setting focal points manually, specify two offset percentages: `crop-x%-y%`.

For example, `fit="crop-75-50"` would crop the image and make sure that the point at 75% across and 50% down would be the focal point.

If asset doesn't have a focal point set it will simply crop from the center.

_Note: All Glide generated images are cropped at their focal point, unless you disable the _Auto Crop_ setting. This happens even when you don't specify a `fit` parameter. You may override this behavior per-image/tag by specifying the `fit` parameter as described above._

## Serving Cached Images Directly

The default behavior is to simply output a URL. When that URL is
visited, Glide analyzes the URL and manipulates an image. However, if there are a lot of manipulation on any given page quest, the total execution time can soon start to add up.

You can avoid these slowdowns by generating static images. Your server will load the images directly instead of handing the work over to the Glide process each time. You can enable this behavior in your assets config file.

``` php
// config/statamic/assets.php

'cache' => true,
```

## Using Glide with Locales

When using Glide with multiple locales, the generated image path will include the proper `site_root` as dictated by the locale, but the actual asset will be stored wherever you have set the `cache_path`.

To serve these assets when on a localized version, you'll need to create a symlink from your `/$locale/cache_path` to `cache_path`.
