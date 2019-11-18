---
title: Multi-Site
intro: Statamic's "multi-site" capabilities are designed to manage a single site with multiple localizations, variations, or sections running on different domains. It can be used to manage translations, country-specific versions of a company site, and other similar idiosyncrasies.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568645080
id: fb20f2e0-3881-43e6-8507-3308a18c54b0
blueprint: page
---
## Overview

Statamic can be configured to handle multiple "sites". A site is a way of localizing content - whether it's into another language, region, or even a company.

Each site can have different base URLs:

- subdomains: `example.com` and `fr.example.com`
- subdirectories: `example.com` and `example.com/fr/`
- even completely different domains: `hello.com` and `bonjour.com`

## Configuration

Whether or not you are using multiple sites, you will need to have at least one site configured.

Each site needs to have a locale, which will be used to display things like date strings.
A URL is also required, which tells Statamic where to expect the site to be served.

``` php
# config/statamic/sites.php

return [
    'sites' => [
        'default' => [
            'name' => config('app.name'),
            'locale' => 'en_US',
            'url' => '/',
        ]
    ]
];
```

## Converting from Single to Multiple Sites

The default single-site setup uses a folder structure optimized for hand editing.

When using a multi-site setup, the folder structure may be a bit more complicated, and you will need to move some files around if changing from a single to multi-site setup.

This conversion can be automated with the following command:

``` bash
php please multisite
```

[More details on how to convert to multi-site setup](/knowledge-base/converting-from-single-to-multi-site)

## Views

Views (templates, layouts, and partials) can be organized into site directories.

If a requested view exists in a subdirectory named after your site, it will load that instead. This lets you have
site-specific views without needing to add any extra configuration.

``` php
# config/statamic/sites.php

'sites' => [
    'site_one' => [ /* ... */ ],
    'site_two' => [ /* ... */ ],
]
```

``` files
resources/views/
|-- site_one/
|   |-- home.antlers.html
|-- home.antlers.html
|-- page.antlers.html
```

For example, if you were to have `template: home`, it would load `site_one.home` because that view exists in the subdirectory. If you were to have `template: page`, it would load the one in the root directory because there's no site-specific version.

>  This feature gets combined with the [AMP](/amp) feature. You can nest an `amp` view subdirectory _inside_ a site subdirectory.
