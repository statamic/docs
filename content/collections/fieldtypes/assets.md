---
title: Assets
meta_title: Assets Fieldtype
intro: Any time you want to list, display, or work with assets (external files with enhanced abilities), this is the way to do it. Upload, browse, reorder, delete, and even manage field data on individual assets.
description: Upload files and use the Asset Browser to pick from existing files in your Asset Containers.
screenshot: fieldtypes/assets-list.png
stage: 1
options:
  -
    name: allow_uploads
    type: bool
    description: |
      Enable to allow uploading new files into the container. Default: `true`.
  -
    name: container
    type: string
    description: |
      The name of the desired [asset container](/assets#containers) to use for browsing, uploading, and managing assets. _Required when the site has more than one container._
  -
    name: folder
    type: string
    description: >
        The folder (relative to the container) to begin browsing. Default: the root folder of the container.
  -
    name: max_files
    type: int
    description: >
      The maximum number of allowed files. Set to `null` for unlimited. If set to `1`, will be saved as a string instead of an array. Default: `null`.
  -
    name: mode
    type: string
    description: >
      Set to `list` to use the table layout mode, and `grid` to use the grid mode with larger thumbnails. Default: `grid`.
  -
    name: restrict
    type: bool
    description: >
      If `true`, navigation within the asset browser will be disabled. Your users will be restricted to specified the container and folder. Default: `false`.

id: d0c65546-74f1-4a15-89d5-1562a95ee2c6
---
## Overview

The assets fieldtype is used to manage and relate files with your entries. From the fieldtype you can manage custom fields on the assets themselves (learn more about that in the [assets guide](/assets)), preview full size images or rich media files, and even set focal points for cropping.

Files are rearrangeable via drag-and-drop.

## UI Modes

The list mode is shown above, while the grid mode is below. There are no functional differences, only visual ones. List mode is more compact – useful if you're not primarily managing images.

<figure>
  <img src="/img/fieldtypes/assets-grid.png" width="543" alt="Assets Grid mode">
  <figcaption>Grid mode reveals a fanny pack in all of its glory.</figcaption>
</figure>

## Data Structure

Data is stored as an array of image paths relative to the asset container. If `max_files` is set to one, a string will be saved instead.

``` yaml
# Default YAML
gallery_images:
  - fresh-prince.jpg
  - dj-jazzy-jeff.jpg
  - uncle-carl.jpg

# With max_items: 1
hero_image: surf-boards.jpg
```

## Templating

The Asset fieldtype uses [augmentation](/augmentation) to automatically relate the files with their Asset records, pull in custom and meta data, and resolve all image paths based on the container.

```
{{ gallery_images }}
    <img src="{{ url }}">
{{ /gallery_images }}
```

### Variables

Inside an asset variable's tag pair you'll have access to the following variables.

| Variable | Description |
|----------|-------------|
| `url` | Web-friendly URL to the file. |
| `path` |  Path to the file relative to asset container |
| `basename` | Name of the file without file extension |
| `blueprint` | Which blueprint is managing the asset container |
| `container` | Which asset container the file is in |
| `edit_url` | URL to edit asset in the Control Panel |
| `extension` | File extension |
| `filename` | Name of the file with file extension |
| `folder` | Which folder the file is in |
| `is_audio` | `true` when file is one of `aac`, `flac`, `m4a`, `mp3`, `ogg`, or `wav`. |
| `is_image` | `true` when file is one of `jpg`, `jpeg`, `png`, `gif`, or `webp`. |
| `is_video` | `true` when file is one of `h264`, `mp4`, `m4v`, `ogv`, or `webm`. |
| `last_modified` | Formatted date string of the last modified time |
| `last_modified_instance` | [Carbon][carbon] instance of the last modified time |
| `last_modified_timestamp` | Unix timestamp of the last modified time |
| `size` | Pre-formatted file size (`3.48 MB`) |
| `size_b` | File size in bytes |
| `size_kb` | File size in kilobytes |
| `size_mb` | File size in megabytes |
| `size_gb` | File size in gigabytes |

### Image Assets

| Variable | Description |
|----------|-------------|
| `height` | height of an image, in pixels |
| `width` | width of an image, in pixels |
| `focus_css` | CSS `background-image` property for a focal point
| `orientation` | Is one of `portrait`, `landscape`, `square`, or `null`. |
| `ratio` |  An image's ratio (`1.77`) |

> You can use [Glide](/tags/glide) to crop, flip, sharpen, pixelate, and perform other sweet image manipulations. Check it out!

### Asset Field Data

All custom data set on the assets will also be available inside the asset tag loop.

```
{{ gallery_images }}
  <figure>
    <img src="{{ url }}" alt="{{ alt }}">
    <figcaption>{{ caption }}</figcaption>
  </figure>
{{ /gallery_images }}
```

## Config Options

[carbon]: https://carbon.nesbot.com/docs/
