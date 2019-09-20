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
    'default' => 'default',

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

1. Add the new site to your `sites.php` config.
2. For each collection:
    - Move all entries into a directory named after the first site's handle. (eg. `content/collections/blog/*.md` into `content/collections/blog/default/*.md`)
    - Add a `sites` array to the collection's yaml file with each site you want the entries to be available in.
3. For each structure:
    - Take the `root`, `route`, and `tree` variables, and move them in a file in a subdirectory named after the first site's handle. (eg. `content/structures/pages.yaml` to `content/structures/default/pages.yaml`)
    - Add a `sites` array to the root structure's yaml file with each site you want the structure to be available in.
4. For each global set:
    - Take the values inside the `data` array, and move them to the top level in a file in a subdirectory named after the first site's handle. (eg. `content/structures/pages.yaml` to `content/structures/default/pages.yaml`)
    - Add a `sites` array to the root global's yaml file with each site you want the structure to be available in.
5. Clear the cache with `php artisan cache:clear`

At this point, your content will be available in the default site. You will need to localize each piece of content by following the steps in its respective documentation.

**If you don't add the `sites` to the respective container files, the site selector will not be visible in the control panel.**

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
