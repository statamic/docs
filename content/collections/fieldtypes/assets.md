---
title: Assets
meta_title: Assets Fieldtype
intro: Upload files and use the Asset Browser to pick from existing files in your Asset Containers.
screenshot: fieldtypes/assets-list.png
options:
  -
    name: allow_uploads
    type: bool
    description: |
      Enable to allow uploading new files into the container. Default: `true`.
  -
    name: container
    type: string
    required: true
    description: |
      The name of the desired [asset container](/assets#containers) to use for browsing, uploading, and managing assets.
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

- Stores relative to asset container
- Meta data stored in `.meta` of each folder

## Templating

- Uses augmentation
- Access to meta data
- Use Glide to manipulate images
- Use the embed modifiers for embedding videos and other files

## Config Options

[private-assets]: /assets#private-assets
