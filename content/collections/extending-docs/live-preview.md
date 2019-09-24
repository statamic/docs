---
title: 'Live Preview'
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347444
id: 06cbe7a2-5322-401a-8bc4-3ab6b20defb7
intro: The Live Preview feature lets you see what an entry will look like on the front-end of your site as you edit it.
---

## Customizing how an entry is rendered

Out of the box, Statamic will push the temporary version of the entry through its usual render process. 

If you have complex requirements – for example, needing to render it through a different frontend – you are able to customize it.

The `LocalizedEntry` class has a `toLivePreviewResponse` method. You can override this and return whatever you want to be
rendered in Live Preview's content pane.

[See how to override the entry classes.](/guide/extending/repositories.html#custom-data-classes)

``` php
<?php

namespace App;

use Statamic\Data\Entries\LocalizedEntry as BaseLocalizedEntry;

class LocalizedEntry extends BaseLocalizedEntry
{
    public function toLivePreviewResponse($request, $extra)
    {
        return response('any html');
    }
}
```

The localized entry (eg. `$this`) will have any temporary values entered in Live Preview applied as supplemented data.

``` php
$this->get('title'); // the original title
$this->getSupplement('title'); // the title as entered in live preview
$array = $this->toArray(); // when converting an entry to an array, the supplemental data overrides the originals
$array['title']; // this would be the title as entered in live preview
```

The `$request` provided to the `toLivePreviewResponse` method will be a faked request to either the entry's absolute
or AMP URL, depending on what the user has selected.

The `$extra` parameter will be an array of the values for any additional inputs.


## Additional Inputs

You may add extra fields to Live Preview's header area using custom Vue components. The values of these fields will be available in the cascade.

Define the inputs using an array of key value pairs of field handles and vue component names in `config/statamic/live_preview.php`:

``` php
'inputs' => [
    'show_ads' => 'live-preview-ads',
]
```

Similar to fieldtypes, this component will be given a `value` prop, and expect any changes to emit an `input` event.

``` js
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

You can use these values in your views under the `live_preview` array:

``` html
{{ if live_preview:show_ads }}
    <div class="ad"> ... </div>
{{ /if }}
```

