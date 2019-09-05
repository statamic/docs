---
title: Glide
overview: Manipulate images on the fly using the wonderful [Glide](http://glide.thephpleague.com/) library.
template: tag-glide
video: https://youtu.be/cwRxk-lqxpg
parameters_content: |
  You may pass any parameter straight from the [Glide API](http://glide.thephpleague.com/1.0/api/quick-reference/) as a parameter.  
  For example, `{{ glide w="300" }}` will use the [width](http://glide.thephpleague.com/1.0/api/size#width-w)
  API parameter. You can also use our easier-to-read alias parameters below. We're not a huge fan of shortening already short words.
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
    type: mixed *auto*
    description: >
      Rotates the image. Accepts `auto`, `0`, `90`, `180` or `270`. The `auto` option uses Exif data to automatically orient images correctly.
  -
    name: quality
    type: integer *90*
    description: >
      Defines the quality of the image. Use values between `0` and `100`. Only relevant if the format is `jpg` or `pjpg`.
  -
    name: format
    type: string *jpg*
    description: >
      Encodes the image to a specific format. Accepts `jpg`, `pjpg` (progressive jpeg), `png` or `gif`.

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

id: b70a3d9a-6605-446e-b278-de99ba561fe0
---
## Examples {#examples}

### Single Images {#single-images}

We have an image's asset URL saved in the YAML, and we want to resize it to 300x200, fit it inside the area by cropping it, and apply a sepia filter.

``` language-yaml
image: "/assets/food/bacon.jpg"
```

```
{{ glide :src="image" width="300" height="200" fit="crop" filter="sepia" }}

<!-- shorthand syntax: -->
{{ glide:image width="300" height="200" fit="crop" filter="sepia" }}
```

``` .language-output
/img/assets/food/bacon.jpg?w=300&h=200&fit=crop&filt=sepia&s=3982hf983f2mf90r23
```

### Multiple Images {#multiple}

If you have a list of assets, you may want to loop over them and generate images for each one. Nothing special here, just loop over them.

``` .language-yaml
images:
  - /assets/food/bacon.jpg
  - /assets/drinks/whisky.jpg
```

Since the current iteration of the loop would be output using `{{ value }}`, you can reference that in the Glide tag like so:

```
{{ images }}
  {{ glide:value width="300" height="200" }}
{{ /images }}
```

``` .language-output
/img/assets/food/bacon.jpg?w=300&h=200&s=3982hf983f2mf90r23
/img/assets/drinks/whisky.jpg?w=300&h=200&s=3982hf983f2mf90r23
```

### Complex image paths {#complex-image-paths}

If you need the path to your image to be generated with another tag, you can't just drop that into the `path` parameter.
It would likely be confusing to read your templates – there could be parameters in parameters, oh my.

Instead, use the `glide` tag as a tag pair. The contents of the tag will be used as the `src`.

```
{{ glide width="300" height="200" fit="crop" filter="sepia" }}
  {{ theme:img src="photo.jpg" }}
{{ /glide }}
```

``` .language-output
/img/site/themes/your-theme/img/photo.jpg?w=300&h=200&fit=crop&filt=sepia&s=3982hf983f2mf90r23
```


## Focal Crop {#focal-crop}

When using the `fit` parameter, you may choose to crop to a focal point. You may specify the
two offset percentages: `crop-x%-y%`.

For example, `fit="crop-75-50"` would crop the image and make sure that the point at 75% across
and 50% down would be the focal point.

Rather than specifying the offsets, you may use `crop_focal` to use the asset's saved focal point.

A Statamic image asset can be assigned a percentage based focal point. You can do this by editing an
asset and defining the focal point using the UI. Or, you may add `focus: x-y` to the asset's metadata.

When using `crop_focal` and an asset doesn't have a focal point set, it will crop from the center.

Note: All Glide generated images are cropped at their focal point, unless you disable the _Auto Crop_
setting. This happens even when you don't specify a `fit` parameter. You may override this behavior
per-image/tag by specifying the `fit` parameter as described above.


## Serving Cached Images Directly {#serving-cached-images}

Glide brings you some pretty nifty on-the-fly URL manipulations. The default behaviour of the Glide tag is to simply output a URL. When that URL is
visited, Glide analyses the URL and manipulates an image. However, if you have a lot of assets in your site and a lot of them on a page, time for each
request can soon start to add up.

It is possible to "reverse" this behavior and to simply generate static images. Your server will load the images directly instead of handing the work
over to Glide each time. If you are familiar with Statamic v1, this can be thought of similar to the "Transform" tag.

In `Configure > Settings > Assets`, or `site/settings/assets.yaml`:

``` .language-yaml
# Enable or disable the feature
image_manipulation_cached: true

# The folder containing the manipulated images.
# If you're running above webroot, this might be something like public/img
image_manipulation_cached_path: img

# The URL to the folder
image_manipulation_route: img
```

## Using Glide with Locales {#glide-and-locales}

When using Glide with multiple locales, the generated image path will include the proper `site_root` as dictated by the locale, but the actual asset will be stored wherever you have set the `image_manipulation_cached_path`. To serve these assets when on a localized version, you'll need to create a symlink from your `/$locale/image_manipulation_cached_path` to `image_manipulation_cached_path`. 
