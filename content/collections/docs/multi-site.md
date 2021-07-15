---
title: Multi-Site
intro: Statamic's "multi-site" capabilities are designed to manage a **single site** with multiple localizations, variations, or sections running on one or more domains or subdomain. It can be used to manage translations, country-specific versions of a company site, and other similar use cases.
template: page
stage: 4
id: fb20f2e0-3881-43e6-8507-3308a18c54b0
blueprint: page
pro: true
---
## Overview

Statamic can be configured to handle multiple "sites". A site is a way of localized version of your content - whether another language, region, or even company or brand (think Proctor & Gamble).

Each site can have different base URLs:

- subdomains: `example.com` and `fr.example.com`
- subdirectories: `example.com` and `example.com/fr/`
- different domains: `hello.com` and `bonjour.com`

## Converting from Single to Multiple Sites

The default single-site setup uses a folder structure optimized for hand editing, but when using a multi-site setup the folder structure is a bit more complex. If you already have a site with content, switching to a multi-site setup will require moving files and folders around.

Luckily for you, this conversion can be done automatically with the following command:

``` bash
php please multisite
```

[More details on how to convert to a multi-site setup](/knowledge-base/converting-from-single-to-multi-site)

## Configuration

Whether you are using multiple sites or not, every Statamic install needs at least one site.

Each site has a locale which is used to format region-specific data, namely date strings.
A URL is also required, telling Statamic where to expect the site to be served.

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

## Site URLs

As mentioned above, each site needs to define a `url`.

Out of the box, the site's `url` is `/`, which should work for most cases. There's a little magic behind the scenes to work out what the full URL should be.

However, it's a good idea to change this to be a full/absolute URL. This guarantees that no server/environment configuration or quirks gets in the way.
Using an environment variable is an ideal solution here.

```php
'sites' => [
    'en' => [
        // ...
        'url' => env('APP_URL')
    ],
    'fr' => [
        // ...
        'url' => env('APP_URL').'fr/'
    ]
]
```

```env
# production
APP_URL=https://mysite.com/
```
```env
# development
APP_URL=http://mysite.test/
```

## Text Direction

If your sites have different text directions, for example if you have an English and a Hebrew version, you can define the direction in the config and use it on your front-end.

```php
'sites' => [
    'en' => [
        'name' => 'English',
    ],
    'he' => [
        'name' => 'Hebrew',
        'direction' => 'rtl',
    ]
]
```

```
<html dir="{{ site:direction }}">
```

> You can omit the `direction` from `ltr` sites since it's the default.

## Attributes

You may add an array of arbitrary attributes to your site's config.

```php
'sites' => [
    'en' => [
        'name' => 'English',
        'attributes' => [
            'theme' => 'standard',
        ]
    ],
]
```

```
<body class="theme-{{ site:attributes:theme }}">
```

> There's nothing fancy going on here. It's just passing the values as-is along to your templates. If you need them to be editable, or store more complex data, you should use [Globals](/globals).

## Views

[Views](/views) can be organized into site directories.

If a requested view exists in a subdirectory named after your site, it will load it instead. This lets you have site-specific views without needing to add any extra configuration.

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

>  This feature can be combined with the [AMP](/amp) feature. You can nest an `amp` view subdirectory _inside_ a site subdirectory. Fancy!
