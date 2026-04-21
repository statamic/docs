---
id: 5b748a3f-be0e-41c1-8877-73f6b7ee1d0a
title: Assets
intro: >
    Used to retrieve [Assets](/assets) directly from a container where you can then loop, filter, and sort them in expected but exciting ways.
description: Fetches Assets from a container
parameters:
  -
    name: id|container|handle
    type: string
    description: |
      Every [asset container](/assets/#containers) has a unique handle. Pass it in and win! Default: `assets`.
  -
    name: folder
    type: string
    description: |
      Filter the resulting assets by specific folder. Default: none.
  -
    name: recursive
    type: boolean
    description: |
      If you enable recursion, the tag will return all the assets in all the subdirectories that match your parameters. Default: `false`.
  -
    name: not_in
    type: string
    description: >
      Filter by excluding from a subdirectory or subdirectories. You may use regex, and will be matched against the file path without a leading slash. For example: `not_in="img/(brand|logos)"`
  -
    name: limit
    type: integer
    description: Limit the total results to a specific number.
  -
    name: offset
    type: integer
    description: Skip a specific number of results. Useful for if you want to pull the first one out as a hero image or something similar.
  -
    name: sort
    type: string
    description: >
      Sort entries by any available asset variable, or `random`. Pipe-separate multiple fields for sub-sorting and specify sort direction of each field using a colon. Example: `sort="size"` or `sort="size:asc|title:desc"` to sort by size _then_ by title.
  -
    name: type
    type: string
    description: >
      Filter by asset type. One of `audio`, `image`, `svg`, or `video`. Default: none.
  -
    name: query_scope
    type: string
    description: >
      Apply a custom [query scope](/extending/query-scopes-and-filters). Reference it by its handle (usually the class name in snake case).
---
## Overview

If you ever find yourself needing to loop over all the assets in a container or folder instead of selecting them manually with the [assets fieldtype](/fieldtypes/assets), this tag was designed to make you smile.

::tabs

::tab antlers
```antlers
{{ assets container="photoshoots" }}
    <img src="{{ url }}" alt="{{ alt }}" />
{{ /assets }}
```

::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<statamic:assets
  container="photoshoots"
>
	<img src="{{ $url }}" alt="{{ $alt }}" />
</statamic:assets>

{{-- Using Fluent Tags --}}
@php
	$assets = Statamic::tag('assets')->container('photoshoots')->fetch();
@endphp

@foreach ($assets as $asset)
	<img src="{{ $asset->url }}" alt="{{ $asset->alt }}" />
@endforeach
```
::

This tag returns an array of [Asset](/assets) objects. You'll have access to all the data and meta data on each file.

## Filtering

### Conditions

You can filter assets using the same [conditions syntax][conditions] available on the Collection tag. This works against both built-in asset properties (`filename`, `extension`, `size`, etc.) and any custom fields defined on the container's blueprint.

::tabs
::tab antlers
```antlers
{{ assets container="photos" extension:is="jpg" alt:contains="sunset" }}
    <img src="{{ url }}" alt="{{ alt }}" />
{{ /assets }}
```

::tab blade
```blade
<statamic:assets
    container="photos"
    extension:is="jpg"
    alt:contains="sunset"
>
    <img src="{{ $url }}" alt="{{ $alt }}" />
</statamic:assets>
```
::

Common conditions include `:is`, `:isnt`, `:contains`, `:starts_with`, and `:ends_with`. See the full list on the [conditions page][conditions].

### Filter by Type

Limit results to a single media type using the `type` parameter. Valid values are `audio`, `image`, `svg`, and `video`.

```antlers
{{ assets container="uploads" type="image" }}
    <img src="{{ url }}" alt="{{ alt }}" />
{{ /assets }}
```

### Custom Query Scopes

For more complex filtering, create a [query scope](/extending/query-scopes-and-filters) and reference it with `query_scope`:

```antlers
{{ assets container="photos" query_scope="recent_hero_shots" }}
    <img src="{{ url }}" alt="{{ alt }}" />
{{ /assets }}
```

[conditions]: /conditions
