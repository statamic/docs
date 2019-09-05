---
id: 5b748a3f-be0e-41c1-8877-73f6b7ee1d0a
title: Assets
video: https://youtu.be/FHhlvKEvgPs
overview: >
    Used to retrieve Assets data from either an [Asset Fieldtype](/fieldtypes/assets) or directly from an Container.
    Your site's Assets are managed and stored independently of your pages and entries and have a joined relationship through their `id`. [Learn more about Assets](/assets).
description: Fetch image/file Assets from an Assets field or container.
parameters:
  -
    name: field
    type: tagpart
    description: |
      Not actually a parameter, but part of the tag. For example, `{{ assets:photos }}` where `photos` is the name
      of the field containing an array of asset IDs.
  -
    name: id|container
    type: string
    description: |
      When retrieving assets directly from a container (_not_ through a field), this is the ID of the container.
  -
    name: folder
    type: string
    description: |
      When retrieving assets directly from a container, this will let you target a specific folder.
  -
    name: recursive
    type: boolean *false*
    description: |
      When retrieving assets directly from a container, this determines whether to get assets recursively through subdirectories.
  -
    name: limit
    type: integer
    description: Limit the total results.
  -
    name: offset
    type: integer
    description: The result set will be offset by this many assets
  -
    name: sort
    type: string
    description: >
      Sort entries by field name (or `random`). You may pipe-separate multiple fields for sub-sorting and specify sort direction of each field using a colon.  
      For example, `sort="size"` or `sort="size:asc|title:desc"` to sort by size then by title.  
variables:
  -
    name: url
    type: string
    description: "The URL of the asset, relative to webroot."

  -
    name: permalink
    type: string
    description: "The absolute URL of the asset, including domain."
  -
    name: title
    type: string
    description: "The title, if set."
  -
    name: path
    type: string
    description: "The relative path from the asset container."
  -
    name: basename
    type: string
    description: "The filename. No path, but with the extension. eg. `jedi.jpg`"
  -
    name: filename
    type: string
    description: "The filename. No path, no extension. eg. `jedi`"
  -
    name: extension
    type: string
    description: "The file extension. eg. `jpg`"
  -
    name: size
    type: string
    description: "A human readable version of the filesize. It will be displayed in the most appropriate format. eg. `36b`, `125KB`, `20MB`, `1.8GB`"
  -
    name: size_bytes
    type: string
    description: "The filesize, in bytes."
  -
    name: size_kilobytes
    type: string
    description: "The filesize, in kilobytes."
  -
    name: size_megabytes
    type: string
    description: "The filesize, in megabytes."
  -
    name: size_gigabytes
    type: string
    description: "The filesize, in gigabytes."
  -
    name: size_b
    type: string
    description: "The filesize, in bytes."
  -
    name: size_kb
    type: string
    description: "The filesize, in kilobytes."
  -
    name: size_mb
    type: string
    description: "The filesize, in megabytes."
  -
    name: size_gb
    type: string
    description: "The filesize, in gigabytes."
  -
    name: last_modified
    type: string
    description: "The time the file was last modified, as a string formatted by whats defined in your config. eg. `January 18th, 2015`"
  -
    name: last_modified_timestamp
    type: string
    description: "The time the file was last modified, as a timestamp."
  -
    name: last_modified_instance
    type: string
    description: "The time the file was last modified, as a `Carbon` instance."
  -
    name: width
    type: integer
    description: The width in pixels, if it's an image.
  -
    name: height
    type: integer
    description: The height in pixels, if it's an image.
---
## Usage {#usage}

The most basic usage is to iterate over an array of asset IDs. The tag takes its second segment from the name of the variable you wish you connect to. For example, if you have an `images` field, you would use `{{ assets:images }}`.

Here's an example of some Assets in use.

``` .language-yaml
bacon_images:
  - /img/applewood-smoked.jpg
  - /img/canadian.jpg
```

```
{{ assets:bacon_images }}
  <img src="{{ url }}" alt="{{ alt }}" /> Size: {{ size }}
{{ /assets:bacon_images }}
```

``` .language-output
<img src="/img/applewood-smoked.jpg" alt="Applewood" /> Size: 355kb
<img src="/img/canadian-bacon.jpg" alt="Canadian" /> Size: 125kb
```

### Single Assets {#single-assets}

If you have an asset field with `max_items: 1` the data will be saved as a `string`. As one cannot iterate over a string, the tag will adjust accordingly without complaining.

``` .language-yaml
hero_image: /img/negasonic-teenage-warhead.jpg
```

```
{{ assets:hero_image }}
<img src="{{ url }}" />
{{ /assets:hero_image }}
```

``` .language-output
<img src="/img/negasonic-teenage-warhead.jpg" />
```

### Asset (singular) Tag {#asset-singular-tag}

You may have noticed that "Assets" is plural.  If you have an array of assets and only want the first or if it bothers you that a plural-powered Tag would return a single asset, we have you covered. We also support the singular word `Asset` for the explicit purpose of only ever accessing a single Asset.

``` .language-yaml
hero_image: /img/quailman.jpg
```

```
{{ asset:hero_image }}
<img src="{{ url }}" />
{{ /asset:hero_image }}
```

``` .language-output
<img src="/assets/img/quailman.jpg" />
```

### Retrieving assets from a container or folder {#retrieving-assets-from-a-container-or-folder}

It may be desirable to loop over all the assets in a container or folder instead of needing to pick out assets manually using a field.

In this case, you may omit the second tagpart, and use parameters to drive the tag.

```
{{ assets container="photoshoots" }}
    <img src="{{ url }}" />
{{ /assets }}
```

Knowing the ID of the container isn't always an option. It may be simpler to specify the path. (This corresponds to
the `path` within a `container.yaml`).

```
{{ assets path="assets" }}
    <img src="{{ url }}" />
{{ /assets }}
```

Lastly, you may target a specific folder in a container, if you wish.

```
{{ assets path="assets" folder="img" }}
    <img src="{{ url }}" />
{{ /assets }}
```
