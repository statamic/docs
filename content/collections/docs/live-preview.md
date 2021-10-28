---
title: 'Live Preview'
intro: 'Live Preview gives you the ability to see what your entry will look like in real time as you write and edit. You can configure and switch the preview screen size, pop it out into a new window, and even switch to AMP mode if enabled.'
template: page
blueprint: page
id: cdffd2c9-cf42-495d-a8f1-f416ddfddc29
---
## Overview

The ability to preview what your content looks like in real-time is practically a super power. You can be confident you won't have any layout surprises.

Live Preview will render your work-in-progress content with whichever template you have currently loaded. You can even switch between templates while previewing.

<figure>
    <img src="/img/live-preview.jpg" alt="Statamic Live Preview">
    <figcaption>And he's still touring, ladies and gentlemen.</figcaption>
</figure>

## Device Sizes

You can customize the list of device sizes in `config/statamic/live_preview.php`.

``` php
    'devices' => [
        'Laptop' => ['width' => 1440, 'height' => 900],
        'Tablet' => ['width' => 1024, 'height' => 786],
        'Mobile' => ['width' => 375, 'height' => 812],
    ],
```

<figure>
    <img src="/img/device-sizes.png" alt="Device Size Switcher" width="441">
    <figcaption>This dropdown will obey you better than any puppy will, guaranteed.</figcaption>
</figure>

## Customizing the Toolbar

You may add extra input fields to Live Preview's header toolbar using custom Vue components. The values of these fields will be available in the data injected into the template.

Define these inputs using an array of key/value pairs of field handles and vue component names in `config/statamic/live_preview.php`:

``` php
'inputs' => [
    'show_ads' => 'live-preview-ads',
]
```

Similar to fieldtypes, this component will be given a value prop and expect any changes to emit an input event.

``` javascript
Statamic.$components.register('live-preview-ads', require('./LivePreviewAds.vue'));
```

``` vue
<template>
    <div>
        <label>
            <input type="checkbox"
                   :value="value"
                   @input="$emit('input', $event.target.checked)" />
            Show Advertisements
        </label>
    </div>
</template>

<script>
export default {
    props: ['value']
}
</script>
```

These values are available in your views, scoped into the `live_preview` array:

```
{{ if live_preview:show_ads }}
    <div class="ad"> ... </div>
{{ /if }}
```

## Custom Render Methods

If you need to customize how Live Preview renders your content — say you're using Statamic as a headless CMS or pushing data into mobile devices or kiosk applications or something equally fancy — follow these steps.

By overriding the `Entry` class's `toLivePreviewResponse()` method, you can return anything you want.

``` php
<?php

namespace App;

use Statamic\Data\Entries\Entry as BaseEntry;

class Entry extends BaseEntry
{
    public function toLivePreviewResponse($request, $extra)
    {
        return response('any html');
    }
}
```

The entry (`$this`) will have access to the temporary values entered in Live Preview, applied as supplemented data.

``` php
// the original title
$this->get('title');

// the title as entered in live preview
$this->getSupplement('title');

// when converting an entry to an array,
// supplemental data overrides original
$array = $this->toArray();

// title as entered in live preview
$array['title'];
```

The `$request` provided to the `toLivePreviewResponse()` method will be a _faked_ request to either the entry's absolute or AMP URL, depending on user selection.

The `$extra` parameter will be an array of the values for any additional inputs.
