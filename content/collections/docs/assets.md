---
title: Assets
intro: >
 Assets are media and document files managed by Statamic. They can be images, videos, PDFs, zip files, or any other kind of file. Each can have fields and content attached to them, just like entries.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568644449
id: 7277432d-bb25-458a-a3a2-a72976b44ad5
stage: 1
blueprint: page
---
## Overview

Assets are the media and document files that you've given Statamic access to. They usually live in folders on your server but can also exist on an [Amazon S3 bucket](https://aws.amazon.com/s3) or other file storage service. Each of these locations is called a **container**..

Statamic will scan the files in each container and cache [meta information](#metadata) (like `width` and `height` for images) about them to speed up interactions and response times when working with them on your front-end.

## Asset Browser
The Control Panel's asset browser gives you a great view on these files. You can file, sort, and search them, move and rename files, preview media files, and even set focal crop points.

<figure>
    <img src="/img/assets.png" alt="Assets browser">
    <figcaption>The asset browser browsin' some assets.</figcaption>
</figure>

## Asset Fields

Asset fields are configured as a [blueprint](/blueprints) and attached to the [container](#containers). Whenever you edit an asset in the Control Panel, you'll see the fields from the configured blueprint.

This data is stored in the asset's [meta data](#metadata) file.

<figure>
    <img src="/img/asset-editor.png" alt="The asset editor editing an image">
    <figcaption>The asset editor in editing an image.</figcaption>
</figure>


## Metadata

- Each asset in a container will have a corresponding yaml file located in a `.meta` subdirectory. eg. `images/tree.jpg` would have an `images/.meta/tree.jpg.yaml`
- These files contain cached data about the files which increases performance (since it doesn't have to be continually recalculated). Things like image dimensions, file size, last modification dates.
- They also contain user generated data. The fields are defined by the asset container's blueprint. Typically things like alt text, focal points, etc.
- Note: This differs from v2, where user generated data lived inside a big array in the container's yaml file.
- The option to version control these files - like the assets themselves - is up to you.

``` yaml
size: 9151
last_modified: 1558533973
width: 216
height: 104
data:
  alt: 'A tree with a tire swing'
  focus: 54-54-1
```

## Containers

Each container has its own settings, configurable permissions, and [blueprint](#blueprint). One container might be a local filesystem with upload, download, rename, and move permissions enabled, and another could be a read-only remote S3 bucket or stock image service. It's up to you.

Containers can be created through the Control Panel and are defined as YAML files located in `content/assets`. Each container's filename becomes its `handle`.

``` yaml
# content/assets/assets.yaml
title: 'Assets'
disk: 'assets'
```

Each container implements a disk, which is just a [Laravel Filesystem](https://laravel.com/docs/filesystem) — a native Laravel feature, which is nothing more than some glue that groups [driver](#drivers), URL, and a location together. Statamic has a nice default asset disk ready for you. You don't need to mess with this stuff unless you want to.

``` php
'disks' => [
    'assets' => [
        'driver' => 'local',
        'root' => public_path('assets'),
        'url' => '/assets',
        'visibility' => 'public',
    ],
]
```

Filesystems are defined in `config/filesystems.php`  They can point to the local filesystem, S3, or anything else as long as there is a Flysystem adapter for it installed.

## Private Containers

Sometimes it’s handy to store assets that shouldn’t be freely accessible through the browser.

<mark>If your asset container's disk does not have a `url` property, Statamic will not output URLs.</mark>

This means you should put the container's disk somewhere above the webroot. If you leave the disk within the webroot, while Statamic won't output URLs, they are _technically_ still accessible if you type the URL manually.

``` files
/
|-- put-it-out-here
|-- public
|   `-- not-in-here
```

If you're using a service based driver (like Amazon S3) then you should make sure you are **not** setting the `visibility`. Or, set it to `private` if you want to be doubly sure.

## Blueprint

If you don't explicitly edit the [Blueprint](/blueprints) for your container, you'll get a single "alt text" field.

If you want to customize the fields, you're able to create your own blueprint. You'll find it in `resources/blueprints/assets/{handle}.yaml`. Or, just go ahead and edit it through the control panel and it'll create the file for you.

## Entries

- The [assets fieldtype](/fieldtypes/assets) will save paths relative to the container.
    ``` yaml
    # blueprint
    -
      handle: images
      field:
        type: assets
    ```
    ``` yaml
    # entry
    images:
      - img/foo.jpg
      - img/bar.jpg
    ```
- Note: This differs from v2, which saved URLs relative to the root.


## Drivers

Statamic uses Flysystem and includes the core `local` driver. S3, SFTP, and other drivers can be [installed with composer](https://laravel.com/docs/filesystem#driver-prerequisites).

Flysystem is not limited to these three, however. There are adapters for many other storage systems. You can [create a custom driver](https://laravel.com/docs/filesystem#custom-filesystems) if you want to use one of these additional adapters in your Laravel application.

## Templating

_Examples and link to Assets tag._

- As long as the entry has an asset field in the blueprint, augmentation will take care of it. Just loop over the array.

    ```
    {{ images }}
        <img src="{{ url }}" alt="{{ alt }}">
    {{ /images }}
    ```

## Image Manipulation

Statamic comes with Glide, a popular image manipulation library. It's really easy to use and even has [it's own tag](/tags/glide).

```
{{ glide:image width="120" height="500" }}
```
