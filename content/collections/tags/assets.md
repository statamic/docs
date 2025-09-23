---
id: 5b748a3f-be0e-41c1-8877-73f6b7ee1d0a
title: Assets
intro: >
    Used to retrieve [Assets](/assets) directly from a container where you can then loop, filter, and sort them in expected but exciting ways.
description: Fetches Assets from a container
stage: 3
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
