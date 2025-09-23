---
id: 245068a1-1900-4774-a3ba-29192dc9acff
blueprint: page
title: 'Image Manipulation (Glide)'
intro: Statamic uses [Glide](https://glide.thephpleague.com) to manipulate images – from resizing and cropping to adjustments (like sharpness and contrast) and image effects (like pixelate and sepia).
---
## Route

The route controls where your Glide images will be served.

```php
'image_manipulation' => [
    'route' => 'img'
]
```

By default your Glide images will be served from `'/img/...'` but you are free to change that. Perhaps if you intend to have some actual images stored in the `img` directory.

:::tip
This route setting may become irrelevant when using customized [caching options](#caching) explained further down this page.
:::

## Presets

Presets are pre-configured sets of manipulations that can be referenced at a later time. They are managed in `config/statamic/assets.php` as an array that holds a list of named presets and their desired parameters.

```php
'image_manipulation' => [
    'presets' => [
        'thumbnail' => [ 'w' => 300,  'h' => 300, 'q' => 75 ],
        'hero'      => [ 'w' => 1440, 'h' => 600, 'q' => 90 ],
    ],
],
```

All standard [Glide API parameters](https://glide.thephpleague.com/2.0/api/quick-reference/) are available for use in presets.

### Glide tag

Each named preset can be referenced with the `preset` parameter on the [Glide tag][glide-tag]:

::tabs

::tab antlers
```antlers
{{ glide:thumbnail preset="thumbnail" }}
<!-- width: 300px, height: 300px, quality: 75% -->

{{ glide:hero_image preset="hero" }}
<!-- width: 1440px, height: 600px, quality: 90% -->
```
::tab blade
```blade
<s:glide:thumbnail preset="thumbnail" />
<!-- width: 300px, height: 300px, quality: 75% -->

<s:glide:hero_image preset="hero" />
<!-- width: 1440px, height: 600px, quality: 90% -->
```
::

### Generate on upload

When uploading an image asset, any configured presets will be generated so they're ready when you need to reference them, e.g. in the Glide tag.

By default, all presets are generated, however you can [customize this per-container](#customize-glide-preset-warming).

You may also choose to disable image generation on upload completely:

```php
'image_manipulation' => [
    'generate_presets_on_upload' => false,
],
```

### Generate manually

You may want to generate the presets manually (for example after you changed the config, and you already uploaded the images, or if you've disabled generation on upload) on the command line:

```bash
php please assets:generate-presets
```

### Process source images

Sometimes you may wish to process your actual source images on upload. For example, maybe you need to enforce maximum dimensions on extremely large images in order to save on disk space.

To do this, first configure an image manipulation preset in `config/statamic/assets.php` for this purpose:

```php
'image_manipulation' => [
    'presets' => [
        'max_upload_size' => ['w' => 2000, 'h' => 2000, 'fit' => 'max'],
    ],
],
```

Then in your asset container settings, you can configure uploads to use this preset:

<figure class="mt-0">
    <img src="/img/glide-process-source-images.png" alt="Glide Process Source Images">
</figure>

:::tip
The `fit` is the important part for this one. Using `max` will ensure images smaller than those dimensions will not be upscaled - only larger images will be resized.
:::

### Customize preset warming

As mentioned [above](#presets), Statamic will generate images for all of your configured presets on upload. (i.e. "warming" the generated images).

By default, Statamic will do this "intelligently", which means it'll generate all presets except for the one used for source processing:

<figure>
    <img src="/img/glide-intelligently-warm.png" alt="Glide Intelligently Warm Presets">
</figure>

However, you may wish to configure which presets are warmed in your asset container settings (or leave this option blank to disable warming altogether):

<figure class="mt-0">
    <img src="/img/glide-warm-specific-presets.png" alt="Glide Warm Specific Presets">
</figure>

:::tip
If you have a preset that's only going to be used with images in one particular container, you should customize which ones are used so your server doesn't have to waste resources on generating and storing images that won't get used.
:::

## Caching

Out of the box, Glide will "just work". However, you may want to adjust its caching methods for better performance.

In the context of Glide, the "source" is the filesystem where the original images are kept, and the "cache" is the filesystem where it saves the manipulated images.

### Default (Dynamic)

The default behavior is for the cache to be "disabled" or "dynamic".

```php
// config/statamic/assets.php
'image_manipulation' => [
    'route' => 'img',
    'cache' => false,
]
```

From a user's point of view, the "cache" is disabled, however technically it's just located at `storage/statamic/glide`.

The [Glide tag][glide-tag] will output URLs to the configured Glide [route](#route). When one of these URLs are visited, Statamic will use Glide to perform the transformation.

:::tip
When using this method, since the Glide tag only needs to generate URLs, the load time of the page will be faster, but the initial load time of each image request will be slower.
:::

:::tip
Be sure to set `STATAMIC_STACHE_WATCHER=false` in your `.env`.
:::

### Custom path (static)

The next level of caching would be to specify a custom, publicly accessible location for the images to be generated.

``` php
// config/statamic/assets.php

'image_manipulation' => [
    'route' => 'img',
    'cache' => true,
    'cache_path' => public_path('img'),
]
```

When using this setting, the [Glide tag][glide-tag] will _actually generate_ the images instead of just outputting a URL.

Since the images are generated to a publicly accessible location, the next time a user visits the image URL, the static image would be served directly by the server, and would not need to be touched by PHP or Statamic.

:::tip
When using this method, since the Glide tag has to generate the images, the initial load time of the page will be slower.
:::

### Custom disk (CDN)

You may choose to save your cached Glide images to somewhere CDN based, like Amazon S3 or DigitalOcean Spaces. Instead of specifying `true` as mentioned above, you can point to a filesystem disk.

```php
// config/statamic/assets.php

'image_manipulation' => [
    'cache' => 'glide',
],
```

```php
// config/filesystems.php  [tl! **]

'disks' => [  // [tl! **]
    'glide' => [  // [tl! **]
        'driver' => 's3',  // [tl! **]
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET_GLIDE'), // [tl! **]
        'url' => env('AWS_URL_GLIDE'),  // [tl! **]
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        'visibility' => 'public',  // [tl! **]
    ],
]
```

:::tip
Make sure that the `visibility` is `public` and that the `url` points to the correct location.
:::

:::warning
Don't use the same disk, bucket or url as your source images. If you were to clear your Glide cache (e.g. when using the `glide:clear` command) the whole disk will be emptied.
:::

## Path cache store

Before Glide tries to generate an image, it will look into the filesystem to determine whether the image has already been generated. This will prevent the need for the image to be needlessly re-generated.

However, when using the [Custom Disk CDN](#custom-disk-cdn) caching option with a service like Amazon S3 for example, Glide will need to make an API call just to be able to check if a file exists. This would cause a slowdown.

To alleviate this problem, Statamic will keep track of whether the images have already been generated in its own separate cache.

This cache is separate from your application cache. Running `php artisan cache:clear` will **not** clear this Glide cache. This allows the Glide cache to persist through deployments or other scenarios where you might clear your application cache. It will be cleared when running `php please glide:clear`.

By default, this cache will be located in your filesystem with the storage directory.

If you would like to customize it, you can create a new store named `glide` in your `config/cache.php` configuration file. For example:

```php
'stores' => [
    'glide' => [
        'driver' => 'redis',
        'connection' => 'glide',
    ],
]
```

In this example, you would also need to create a Redis database named `glide` in your `config/database.php` configuration file:

```php
'redis' => [
    'glide' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_GLIDE_DB', '2'),
    ],
],
```

When using the [database driver](https://laravel.com/docs/12.x/cache#prerequisites-database), make sure to specify the connection and table, like so:

```php
'glide' => [
    'driver' => 'database',
    'connection' => 'mysql',
    'table' => 'cache',
],
```

## Clearing the cache

You may manually clear the Glide cache by running the following command:

```
php please glide:clear
```

This will **delete all the files** within your Glide cache filesystem location, as well as clearing the [path cache](#path-cache-store).


[glide-tag]: /tags/glide
