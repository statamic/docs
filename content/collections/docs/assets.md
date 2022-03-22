---
id: 7277432d-bb25-458a-a3a2-a72976b44ad5
blueprint: page
title: Assets
intro: 'Assets are files managed by Statamic and made available to your writers and developers with tags and fieldtypes. They can be images, videos, PDFs, or any other type of file. Asset can have fields and content attached to them, just like entries, making them very powerful.'
template: page
related_entries:
  - 5b748a3f-be0e-41c1-8877-73f6b7ee1d0a
  - b70a3d9a-6605-446e-b278-de99ba561fe0
  - 7277432d-bb25-458a-a3a2-a72976b44ad5
  - 0c30a664-9bc3-4c5e-ad8c-66452b049748
  - b50310b0-64ae-4ae4-b219-a637ed89e4d7
  - 458b8203-e330-4d78-9bf5-82aaec8d458b
  - d0c65546-74f1-4a15-89d5-1562a95ee2c6
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1633025886
---
## Overview

Assets live in directories on your local server, in an [Amazon S3 bucket](https://aws.amazon.com/s3), or other cloud storage services. Each defined location is called a **container**..

Statamic scans the files in each container and caches [meta information](#metadata) (like `width` and `height` for images) on them. This cache is used to speed up interactions and response times when working with them on the [frontend](/frontend) of your site.

## Asset Browser

You can explore these files in the Control Panel's asset browser. You can file, sort, search, move, rename, preview, and — if working with images — even set focal crop points to make dynamically resized images look their best.

<figure>
    <img src="/img/assets.png" alt="Assets browser">
    <figcaption>Browsing some assets.</figcaption>
</figure>

## Asset Fields

Asset fields are configured like a [blueprint](/blueprints) and attached to the [container](#containers). Whenever you edit an asset in the Control Panel, you'll see the fields from the configured blueprint.

This data is stored in the asset's [meta data](#metadata) file.

<figure>
    <img src="/img/asset-editor.png" alt="The asset editor editing an image">
    <figcaption>Editing an image with the asset editor.</figcaption>
</figure>

## Metadata

Asset metadata is stored in YAML files inside a hidden `.meta` subdirectory inside each container. For example, `images/tree.jpg` gets an `images/.meta/tree.jpg.yaml` cache file.

These files contain cached data, including but not limited to: image dimensions, file size, last modification dates, and so on.

These cache files can also contain user created data. The fields are defined by the asset container's blueprint. Typically these are alt text, focal points, descriptions, and so on, but they could be anything you want at all.

``` yaml
size: 9151
last_modified: 1558533973
width: 216
height: 104
data:
  alt: 'A tree with a tire swing'
  focus: 54-54-1
```

:::tip
You should consider version controling these files if you plan to set data like alt tags and focal points. Make sure your efforts are preserved.
:::

## Containers

Each container has its own settings, configurable permissions, and [blueprint](#blueprints). One container might be a local filesystem with upload, download, rename, and move permissions enabled, and another could be a read-only remote S3 bucket or stock image service.

Containers can be created through the Control Panel and are defined as YAML files located in `content/assets`. Each container's filename becomes its `handle`.

``` yaml
# content/assets/assets.yaml
title: 'Assets'
disk: 'assets'
```

Each container implements a "disk", also known as a [Laravel Filesystem](https://laravel.com/docs/filesystem). This native Laravel feature groups a [driver](#drivers), URL, location, and [visibility](#container-visibility) together. Statamic includes a local disk on fresh installs. You can modify or delete it, but many sites can simply use it as is.

``` php
'disks' => [
    'assets' => [
        'driver' => 'local',
        'root' => public_path('assets'),
        'url' => '/assets',
        'visibility' => 'public', // (more info about visibility below)
    ],
]
```

Filesystems are defined in `config/filesystems.php`  They can point to the local filesystem, S3, or any [Flysystem adapter](https://flysystem.thephpleague.com/v2/docs/).

### Private Containers

Sometimes it’s handy to store assets that shouldn’t be publicly visible through a direct URL or browser.

:::tip
If your asset container's disk does not have a `url` property, Statamic will not output URLs.
:::

Private containers should be located above webroot. If you leave the disk within the webroot, the files will still be accessible directly outside of Statamic if you know the file path.

``` files theme:serendipity-light
/
  app/
  content/
  config/
  public/
    not-in-here/ # [tl! ~~]
    index.php
  put-it-out-here/ # [tl! ~~]
  resources/
  vendor/
```

Make sure to also set the [visibility](#container-visibility) to `private`.


### Container Visibility

Your filesystem's disk can have a `visibility` which is an abstraction of file permissions. You can set it to `public` or `private`,
which essentially controls whether they're accessible or not.

Be sure to set `'visibility' => 'public',` if you want to be able to see, interact with, and manipulate files in your container.

:::tip
If you're using a service based driver like Amazon S3, and you want the files to be accessible by URL, make sure you set the [visibility](#container-visibility) to `public`.
:::

## Blueprints

The default container [Blueprint](/blueprints) contains a single "alt text" field — just useful and simple enough to get you started.

You can customize the fields on the blueprint by visiting the container in the Control Panel and choosing "Edit Blueprint" in the options dropdown.

If you want to edit the blueprint file directly, you can do so in `resources/blueprints/assets/{handle}.yaml`.

## Drivers

Statamic uses Flysystem and includes the core `local` driver. S3, SFTP, and other drivers can be [installed with composer](https://laravel.com/docs/filesystem#driver-prerequisites).

Flysystem is not limited to these three, however. There are adapters for many other storage systems. You can [create a custom driver](https://laravel.com/docs/filesystem#custom-filesystems) if you want to use one of these additional adapters in your Laravel application.


## Frontend Templating {#templating}

There are two main methods for working with Asset data on the frontend. The Assets Fieldtype, and the Assets Tag.

### Assets Fieldtype

The [Assets Fieldtype](/fieldtypes/assets) can be used in your content Blueprints to attach assets to your entries, taxonomy terms, globals, or user accounts. It can be used to create image galleries, video players, zip downloads, or anything else you can think of.

All of the data stored on your Assets will be available on the frontend without having to create any kind of duplication.

#### Example

If you had a `slideshow` field with a whole bunch of images selected, you can render them by looping through them.

```
<div class="slideshow">
    {{ slideshow }}
        <img src="{{ url }}" alt="{{ alt }}">
    {{ /slideshow }}
</div>
```

Learn more about the [Assets Fieldtype](/fieldtypes/assets).

### Assets Tag

If you ever find yourself needing to loop over all of the assets in a container (or folder inside a container) instead of selecting them manually with the Assets Fieldtype, this is the way.

#### Example
```
{{ assets container="photoshoots" limit="10" sort="rating" }}
    <img src="{{ url }}" alt="{{ alt }}" />
{{ /assets }}
```

Learn more about the [Assets Tag](/tags/assets) and what you can do with it.

### Manipulating Images

Statamic uses the [Glide library](https://glide.thephpleague.com/) to dynamically resize, crop, and manipulate images. It's really easy to use and has [its own tag](/tags/glide).

```
{{ glide:image width="120" height="500" filter="sepia" }}
```
