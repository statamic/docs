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
This route setting may become irrelevant when using customizing [caching options](#caching) explained further down this page.
:::

## Presets

Glide Presets are pre-configured manipulations that will be automatically generated when new image assets are uploaded. These presets are managed in `config/statamic/assets.php` as an array that holds a list of named presets and their desired parameters.

```php
'image_manipulation' => [
    'presets' => [
        'thumbnail' => [ 'w' => 300, 'h' => 300, 'q' => 75],
        'hero'      => [ 'w' => 1440 'h' => 600, 'q' => 90 ],
    ],
],
```

All standard Glide API parameters are available for use in presets. (Not the tag aliases like `width`. You'll need to use `w`.)

Each named preset can be referenced with the `preset` parameter on the [Glide tag][glide-tag] and since all transformations and manipulations are performed at time of upload, there shouldn't be any additional overhead on the initial request.

**Example:**

```
{{ glide:thumbnail preset="thumbnail" }}
<!-- width: 300px, height: 300px, quality: 75% -->

{{ glide:hero_image preset="hero" }}
<!-- width: 1440px, height: 600px, quality: 90% -->
```

## Caching

Out of the box, Glide will "just work". However you may want to adjust its caching methods for better performance.

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

### Custom Path (Static)

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

### Custom Disk (CDN)

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
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),  // [tl! **]
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
Don't use the same disk or bucket as your source images. If you were you to clear your Glide cache (e.g. when using the `glide:clear` command) the whole disk will be emptied.
:::

## Path Cache Store

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

## Clearing the cache

You may manually clear the Glide cache by running the following command:

```
php please glide:clear
```

This will **delete all the files** within your Glide cache filesystem location, as well as clearing the [path cache](#path-cache-store).


[glide-tag]: /tags/glide
