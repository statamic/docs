---
title: Assets
intro: >
 Assets are media and document files managed by Statamic. They can be images, videos, PDFs or even zip files and can have fields and content attached to them, just like entries.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568644449
id: 7277432d-bb25-458a-a3a2-a72976b44ad5
blueprint: page
---
## Overview

Assets are the media and document files that you've given Statamic access to. They usually live in folders on your server but can also exist on an [Amazon S3 bucket](https://aws.amazon.com/s3) or other file storage service.

Statamic will scan these files and cache basic meta information (like `width` and `height` for images) about them to speed up interactions and response times.

<figure>
    <img src="/img/assets.png" alt="Assets browser">
    <figcaption>The asset browser browsin' some assets.</figcaption>
</figure>

The Control Panel's asset browser gives you a great view on these files. You can file, sort, and search them, move and rename files, preview media files, and even

Assets are grouped into **containers**, each with its own settings, configurable permissions, and [blueprints](/blueprints). One container might be a local filesystem with upload, download, rename, and move permissions enabled, and another could be a read-only remote S3 bucket or stock image service. It's up to you.

## Metadata

- Each asset in a container will have a corresponding yaml file located in a `.meta` subdirectory. eg. `images/tree.jpg` would have an `images/.meta/tree.jpg.yaml`
- These files contain cached data about the files which increases performance (since it doesn't have to be continually recalculated). Things like image dimensions, file size, last modification dates.
- They also contain user generated data. The fields are defined by the asset container's blueprint. Typically things like alt text, focal points, etc.
- Note: This differs from v2, where user generated data lived inside a big array in the the container's yaml file.
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

## Asset Fields

_Examples and screenshot of Asset editor_.

- When editing an asset in the CP, the editor will get its fields from the `blueprint` defined in the container.
- Asset data is stored in the asset's [meta data](#metadata) file.

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

## Containers

- A container is any yaml file located in `content/assets`. The `handle` is the filename.
- It should have a `disk` variable with the name of a filesystem from `config/filesystems.php`
    ``` yaml
    title: 'Assets'
    disk: 'assets'
    ```
    ``` php
    'disks' => [
        'assets' => [
            'driver' => 'local',
            'root' => public_path('assets'),
            'url' => env('APP_URL').'/assets',
            'visibility' => 'public',
        ],
    ]
    ```
- Filesystem disks are entirely a [Laravel concept](https://laravel.com/docs/filesystem). They can point to the local filesystem, S3, or anything else as long as there is a Flysystem adapter for it installed.

## Drivers

- Being a Laravel feature, the Flysystem included drivers are whatever Laravel includes: Local, S3, and SFTP (the last 2 require a composer dependencies).
- More Flysystem drivers can be installed by following Laravel's [Custom Filesystems docs](https://laravel.com/docs/6.x/filesystem#custom-filesystems).

## Templating

_Examples and link to Assets tag._

- As long as the entry has an asset field in the blueprint, augmentation will take care of it. Just loop over the array.

    ```
    {{ images }}
        {{ url }} {{ alt }}
    {{ /images }}
    ```

## Image Manipulation

_Examples and link to Glide tag_.
