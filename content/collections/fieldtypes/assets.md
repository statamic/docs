---
title: Assets
overview: Upload files and use the Asset Browser to pick from existing files in your Asset Containers.
video: https://youtu.be/FHhlvKEvgPs
image: /assets/fieldtypes/assets.png
options:
  -
    name: container
    type: string
    description: |
      The ID of the default asset container. When dragging files into the fieldtype, they will be uploaded to this container.
      Unless the `restrict` option is set, navigation between all containers will be allowed in the browser dialog.
  -
    name: folder
    type: string
    description: >
        The folder (relative to the container) to use. If left blank, the root folder of the container will be used.
  -
    name: max_files
    type: int
    description: The maximum number of allowed files. If left blank, there will be no limit. If set to 1, the asset will be saved as a string instead of an array
  -
    name: restrict
    type: bool
    description: >
      If set to `true`, navigation within the browser dialog will be disabled, and you
      will be restricted to the container and folder specified.
  -
    name: validate
    type: string
    description: >
      A pipe delimited string of [validation rules](http://laravel.com/docs/5.1/validation#available-validation-rules), but you may also use an `ext` rule to restrict extensions.
      For example: `validate: "ext:jpg,gif"`

id: d0c65546-74f1-4a15-89d5-1562a95ee2c6
---
## Data Structure {#data-structure}

The Assets fieldtype can upload files to existing Containers and stores the URL (or ID for [private assets][private-assets]) of all uploaded and/or selected files.

``` .language-yaml
bacon_images:
  - /assets/applewood-smoked.jpg
  - /assets/canadian-bacon.jpg
```

## Templating {#templating}

If URLs are all you need, simply loop through the array:

```
{{ bacon_images }}
    <img src="{{ value }}" />
{{ /bacon_images }}

<img src="{{ bacon_images:0 }}" />
```

``` .language-output
<img src="/assets/applewood-smoked.jpg" />
<img src="/assets/canadian-bacon.jpg" />

<img src="/assets/applewood-smoked.jpg" />
```

Using the array on its own won't be enough if:

- You need to access [asset variables](/variables#asset) or your own [additional asset data](/assets#additional-data)
- You're dealing with [private assets][private-assets]

In that case, use the [Assets tag](/tags/assets), which will make the data available to you.

```
{{ assets:bacon_images }}
  <img src="{{ url }}" alt="{{ alt }}" />   Size: {{ size }}
{{ /assets:bacon_images }}
```

``` .language-output
<img src="/assets/applewood-smoked.jpg" alt="Applewood" /> Size: 355kb
<img src="/assets/canadian-bacon.jpg" alt="Canadian" /> Size: 125kb
```

[private-assets]: /assets#private-assets
