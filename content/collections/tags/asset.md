---
title: Asset
description: Retrieves an Asset by its URL
intro: The Asset (singular tense) tag retrieves single assets by their URL.
parameters:
  -
    name: url
    type: string
    description: >
      The path to the file, relative to the web root.
stage: 4
id: de348605-5489-4282-9257-bd9ffd92438e
---
## Overview

The Asset tag's primary purpose is to retrieve [Assets](/assets) by their URL.  Pass the URL into the `url` parameter and voila. To say it did any more than that would be a lie.

## Example

::tabs

::tab antlers
```antlers
{{ asset url="/img/brand/logo.png" }}
  <img src="{{ url }}" alt="{{ alt }}" />
{{ /asset }}
```
::tab blade
```blade
{{-- Using Statamic Tags --}}
<statamic:asset
  url="/assets/logo.png"
>
	<img src="{{ $url }}" alt="{{ $alt }}" />
</statamic:asset>

{{-- Using Fluent Tags --}}
@if ($asset = Statamic::tag('asset')->src('/assets/logo.png')->fetch())
	<img src="{{ $asset->url }}" alt="{{ $asset->alt }}" />
@endif
```
::
