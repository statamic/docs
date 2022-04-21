---
title: Glide
description: Manipulates images on the fly
intro: The Glide tag makes it easy to manipulate images on the fly – from resizing and cropping to adjustments (like sharpness and contrast) and image effects (like pixelate and sepia).
template: tags.glide
blueprint: tag-glide
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
    required: true
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
  -
    name: preset
    type: string
    description: >
      Use a preset of pre-configured parameters. [Learn more](#presets).
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
      A shortcut for setting `width` and `height` to the same value. For example `square="250"` is a shortcut for `width="250" height="250"`.
  -
    name: fit
    type: string
    description: >
      See the [Glide docs](http://glide.thephpleague.com/1.0/api/size/#fit-fit) on this parameter. In addition to the
      Glide's fit options, Statamic also supports `crop_focal` to automatically fit/crop to a predefined focal point.
      See the [_Focal Crop_](#focal-point-cropping) section for more details.
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
      Defines the quality of the image. Use values between `0` and `100`. Only relevant if the format is `jpg`, `pjpg` or `webp`. Default: `90`.
  -
    name: dpr
    type: integer
    description: >
      Defines the device pixel ratio. This makes it possible to display images at the correct pixel density on a variety of devices. For example the following would output an image of 400px `{{ glide:image width="200" dpr="2" square }}`. Default: `1`. The maximum value that can be set for dpr is `8`.
  -
    name: format
    type: string
    description: >
      Encodes the image to a specific format. Accepts `jpg`, `pjpg` (progressive jpeg), `png`, `gif`, `webp` or `avif`. If using the imagick image manipulation driver, glide can additionally handle `tif`, `bmp` and `psd`. The default format: `jpg`

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
other:
  -
    name: preset
    type: string
    description: >
      Applies a [preset manipulation](/image-manipulation#presets) as defined in the config.
  -
    name: mark
    type: string
    description: >
      The source of a [watermark](#watermarks).
  -
    name: markw
    type: string
    description: The width of the watermark.
  -
    name: markh
    type: string
    description: The height of the watermark.
  -
    name: markfit
    type: string
    description: The fit of the watermark. [See Glide docs](https://glide.thephpleague.com/2.0/api/watermarks/#fit-markfit)
  -
    name: markx
    type: string
    description: How far the watermark is away from the left and right edges.
  -
    name: marky
    type: string
    description: How far the watermark is away from the top and bottom edges.
  -
    name: markpad
    type: string
    description: How far the watermark is away from all edges. A shortcut for using markx and marky.
  -
    name: markpos
    type: string
    description: Sets where the watermark is positioned. Accepts `top-left`, `top`, `top-right`, `left`, `center`, `right`, `bottom-left`, `bottom`, `bottom-right`. Default is `bottom-right`.
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
  -
    name: asset data
    type: mixed
    description: If your source was an asset, you will also have all of its fields available. e.g. `alt`
id: b70a3d9a-6605-446e-b278-de99ba561fe0
---
## Setting up Glide
Glide is ready to go out of the box with no setup required. However, you may customize its behavior. You can read about it on the [image manipulation](/image-manipulation) page.

## Basic Usage

Manipulate images by passing an image [source](#sources) and adding the desired [parameters](#parameters) like `height`, `crop`, or `quality`.

```
{{ glide src="image.jpg" width="1280" height="800" }}
```
```output
/img/image.jpg?w=1280&h=800
```

The Glide tag outputs a URL of the transformed image, so you'll likely want to use it as the `src` for an `<img />` HTML tag.

```
<img src="{{ glide ... }}" />
```

## Sources

There are a number of options when it comes to what you can use as an image source.

### Asset
You can pass along an asset object by using an asset field by reference:

```
{{ glide :src="asset_field" w="100" }} // /img/asset/6f75d8as?w=100
```

### Relative path/URL
You can pass a string of a path located within your `public` directory.

```
{{ glide src="image.jpg" w="100" }} // img/image.jpg?w=100
```

### External URL
You can pass a string of a URL on another site.

```
{{ glide src="http://anothersite.com/image.jpg" w="100" }} // /img/http/6f75d8as?w=100
```


## Tag Pair

If you use the tag as a pair, you'll have access to `url`, `height`, and `width` variables inside to do with as you wish.

```
{{ glide src="image.jpg" width="600" }}
    <img src="{{ url }}" width="{{ width }}" height="{{ height }}">
{{ /glide }}
```

You may also use the tag pair to loop over multiple sources. For example, you may provide it with an `assets` field.

```
{{ glide :src="multiple_assets" width="600" }}
   ...
{{ /glide }}
```

:::tip
The tag pair is also available as `{{ glide:generate }}`. You may need to use this version if you're using [Blade](#usage-in-blade).
:::

:::tip
Normally, the Glide tag only generates a URL. The image itself is generated when the URL is visited. When using the tag pair, your Glide images will be generated when the page is rendered. This will result in an initial longer load time.
:::


## Shorthand Tag

Rather than using the `src` parameter, you may choose to use a variable name as the second part of the tag.

```
{{ glide:my_var w="100" }}
```

You may also use the shorthand as a tag pair:

```
{{ glide:my_var }} ... {{ /glide:my_var }}
```


## Watermarks

You may use Glide's [watermarking feature](https://glide.thephpleague.com/2.0/api/watermarks/) by passing in a [source](#sources) to the `mark` parameter, and then manipulate it using the various watermark parameters (`markw`, `markh`, `markfit`, etc).

```
{{ glide src="image.jpg" mark="watermark.jpg" markw="30" }}
```

:::tip
You don't need to worry about setting up a watermark filesystem yourself. Statamic will take care of that automatically based on the source you provide.
:::


## Usage in Blade

To use the Glide tag within Blade, you should use the `generate` tag, which follows the same rules as the [tag pair](#tag-pair).

```blade
@foreach (Statamic::tag('glide:generate')->src($source)->width(100) as $image)
  <img src="{{ $image['url'] }} width="{{ $image['width'] }}" />
@endforeach
```

You should use a `@foreach` loop even if you are only providing a single source.

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

If an asset doesn't have a focal point set it will simply crop from the center.

_Note: All Glide generated images are cropped at their focal point, unless you disable the _Auto Crop_ setting. This happens even when you don't specify a `fit` parameter. You may override this behavior per-image/tag by specifying the `fit` parameter as described above._


``` php
// config/statamic/assets.php

'auto_crop' => true,
```

## Unsupported formats

Glide will resize whatever images it supports, like jpgs or pngs. If you pass an unsupported type to Glide, like an svg, it'll just return the unmodified URL.

``` yaml
images:
  - image.jpg
  - image.svg
```

```
{{ images }}
  <img src="{{ glide:url width="600" }}" />
{{ /images }}
```

```html
<img src="/img/image.jpg?w=600" />
<img src="/assets/image.svg" />
```
