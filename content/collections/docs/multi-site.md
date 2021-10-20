---
title: Multi-Site
intro: Statamic's "multi-site" capabilities are designed to manage a **single site** with multiple localizations, variations, or sections running on one or more domains or subdomain. It can be used to manage translations, country-specific versions of a company site, and other similar use cases.
template: page
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

``` shell
php please multisite
```

[More details on how to convert to a multi-site setup](/tips/converting-from-single-to-multi-site)

## Configuration

Let's look at a basic site configuration, and then we'll walk through each configuration option.

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

### Sites
Every Statamic install needs at least one site, whether you are using multiple sites or not. Building zero sites is a bad way to build a website and clients will probably challenge any invoices.

### Locale
Each site has a `locale` which is used to format region-specific data (like date strings).

### URL
A URL is also required, which defines where statamic will serve and generate all URLs relative to.


## Site URLs

As mentioned above, each site needs to define a `url`.

The default site `url` is `/`, which is portable and works fine in most typical sites. Statamic uses a little magic to work out what a full URL should be, based on the domain the site is running on.

:::best-practice
It can be a good idea to change this to a **fully qualified, absolute URL**. This ensures that server/environment configurations or external quirks interfere with that "magic". Using an environment variable is an ideal solution here.

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

# development
APP_URL=http://mysite.test/
```

:::

## Text Direction

If your site or sites have different text directions, for example if you have an English and a Hebrew version, you can define the direction in the config and use it on your front-end.

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

:::tip
Statamic's `direction` is `ltr` by default. You only need to set `direction` when your site is `rtl`.
:::

## Additional Attributes

You may also add an array of arbitrary attributes to your site's config, which can later be accessed with the [site variable](/variables/site) .

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

:::tip
Nothing fancy happens here, the values are passed along "as is" to your templates. If you need them to be editable, or store more complex data, you could use [Globals](/globals).
:::

## Views

[Views](/views) can be organized into site directories.

If a requested view exists in a subdirectory with the same name as your site, it will load it instead. This allows you have site-specific views without any extra configuration.

``` php
# config/statamic/sites.php

'sites' => [
    'site_one' => [ /* ... */ ],
    'site_two' => [ /* ... */ ],
]
```

``` files theme:serendipity-light
resources/views/
    site_one/
        home.antlers.html
    home.antlers.html
    page.antlers.html
```

For example, given `template: home`, Statamic will load `site_one/home` because that view exists in the subdirectory. If you were to have `template: page`, it would load the one in the root directory because there's no site-specific variant.

:::tip
This feature can be combined with the [AMP](/amp) feature. You can nest an `amp` view subdirectory _inside_ a site subdirectory.
:::
