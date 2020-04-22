---
title: AMP
template: page
intro: |
    [AMP](https://amp.dev) (Accelerated Mobile Pages) is a web component framework by Google to serve fast, content-optimized versions of your websites.
stage: 3
id: a66f3e5f-5a60-44c4-8c1d-a9d9692366c0
---
## Overview

Statamic supports [AMP]((https://amp.dev)) by providing a "pivot" route which serves an alternate set of views and layouts conforming to AMP requirements.

## Turn it On

Enable AMP globally as an option in `config/statamic/amp.php`. Any entry with a URL will then have its AMP version available at ` /amp/{url}`.

``` php
'enabled' => true,
```

### Collections
Once enabled, you will have the ability to enable AMP on your individual collections.

``` yaml
#content/collections/blog.yaml
amp: true
```

### Routes
You can add `'amp' => true` to a route to AMP it.

``` php
// config/statamic/routes.php
'routes' => [
    '/flat' => [
        'template' => 'flat',
        'amp' => true,
    ]
]
```

## AMP Views

Whenever you visit `/amp/{url}` it will attempt to load whatever entry would be found at {url}, and swap out the regular view for a magical AMP one ✨.

AMP views follow the same exact file locations as regular views, except in an `/amp` subdirectory.

``` files
resources/views/
|-- amp/
|   |-- blog/
|   |--   |-- index.antlers.html
|   |--   |-- show.antlers.html
|   |-- blog/
|   |--   |-- index.antlers.html
|   |--   |-- show.antlers.html
```

For example, if an entry loaded a `blog/show` view by default, its AMP view would be `amp/blog/show`. You will need to create these alternate views yourself.

## Variables

If an entry has an AMP URL, it will a corresponding `amp_url` variable. You can use this to point to your AMP document from the original.

```
<link rel="amphtml" href="{{ amp_url }}" />
```

Similarly, you can use the permalink on the AMP view to link back to the canonical original.

```
<link rel="canonical" href="{{ permalink }}" />
```

## Live Preview

When enabled, the [Live Preview](/live-preview) feature has the ability to preview the AMP versions of your entries.
