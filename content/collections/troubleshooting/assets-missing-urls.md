---
id: 458b8203-e330-4d78-9bf5-82aaec8d458b
title: 'Assets are Missing URLs'
template: page
categories:
  - troubleshooting
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821385
---
Trying to output an asset's details and `url` is just blank?

Perhaps `alt` text, even `width` and `height` work, but not `url`?
You might have something like this:

``` yaml
my_asset_field:
  - path/to/image.jpg
```

::tabs

::tab antlers
```antlers
{{ my_asset_field }}
  <img
    src="{{ url }}" alt="{{ alt }}"
    width="{{ width }}" height="{{ height }}"
  />
{{ /my_asset_field }}
```
::tab blade
```blade
@foreach ($my_asset_field as $asset)
  <img
    src="{{ $asset->url }}" alt="{{ $asset->alt }}"
    width="{{ $asset->width }}" height="{{ $asset->height }}"
  />
@endforeach
```
::

```html
<img src="" alt="An image" width="100" height="150" />
```

That'll be because your Asset Container's disk does not have a `url` configured.

``` yaml
# content/assets/my_container.yaml
disk: assets
```

``` php
// config/filesystems.php
'disks' => [
    'assets' => [
        'driver' => 'local',
        'root' => public_path('assets'),
        'visibility' => 'public',
        'url' => '/assets', // 👈 you're missing this
    ],
]
```

Asset containers using url-less disks are considered "private" and will intentionally not output URLs.

[Read about private asset containers](/assets#private-containers)
